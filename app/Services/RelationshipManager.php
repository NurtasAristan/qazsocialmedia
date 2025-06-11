<?php

namespace App\Services;

use App\Models\Person;
use App\Models\Relationship;

class RelationshipManager
{
    /**
     * Создать связь между двумя персонами
     * 
     * @param Person $person1 Первая персона
     * @param Person $person2 Вторая персона
     * @param string $type Тип отношения (parent, spouse)
     * @return Relationship
     */
    public function createRelationship(Person $person1, Person $person2, string $type): Relationship
    {
        // Проверяем, что такая связь еще не существует
        $existingRelationship = Relationship::where('person1_id', $person1->id)
            ->where('person2_id', $person2->id)
            ->where('type', $type)
            ->first();
        
        if ($existingRelationship) {
            return $existingRelationship;
        }
        
        // Создаем новую связь
        return Relationship::create([
            'person1_id' => $person1->id,
            'person2_id' => $person2->id,
            'type' => $type
        ]);
    }
    
    /**
     * Добавить родителя для ребенка
     * 
     * @param Person $parent Родитель
     * @param Person $child Ребенок
     * @return Relationship
     */
    public function addParent(Person $parent, Person $child): Relationship
    {
        return $this->createRelationship($parent, $child, 'parent');
    }
    
    /**
     * Добавить ребенка для родителя
     * 
     * @param Person $parent Родитель
     * @param Person $child Ребенок
     * @return Relationship
     */
    public function addChild(Person $parent, Person $child): Relationship
    {
        return $this->createRelationship($parent, $child, 'parent');
    }
    
    /**
     * Добавить супружескую связь между мужем и женой
     * 
     * @param Person $husband Муж
     * @param Person $wife Жена
     * @return Relationship
     */
    public function addSpouse(Person $husband, Person $wife): Relationship
    {
        // Проверяем, что husband - мужчина, а wife - женщина
        if ($husband->gender !== 'male' || $wife->gender !== 'female') {
            throw new \InvalidArgumentException('Для супружеской связи: первый человек должен быть мужчиной, второй - женщиной');
        }
        
        return $this->createRelationship($husband, $wife, 'spouse');
    }
    
    /**
     * Получить всех детей персоны
     * 
     * @param Person $person Персона
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getChildren(Person $person)
    {
        return Person::whereHas('relationshipsAsSecond', function($query) use ($person) {
            $query->where('person1_id', $person->id)
                  ->where('type', 'parent');
        })->get();
    }
    
    /**
     * Получить всех родителей персоны
     * 
     * @param Person $person Персона
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getParents(Person $person)
    {
        return Person::whereHas('relationshipsAsFirst', function($query) use ($person) {
            $query->where('person2_id', $person->id)
                  ->where('type', 'parent');
        })->get();
    }
    
    /**
     * Получить всех братьев и сестер персоны (общие родители)
     * 
     * @param Person $person Персона
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSiblings(Person $person)
    {
        $parents = $this->getParents($person);
        $siblings = collect();
        
        foreach ($parents as $parent) {
            $children = $this->getChildren($parent);
            foreach ($children as $child) {
                if ($child->id !== $person->id && !$siblings->contains('id', $child->id)) {
                    $siblings->push($child);
                }
            }
        }
        
        return $siblings;
    }
    
    /**
     * Получить супруга(у) персоны
     * 
     * @param Person $person Персона
     * @return Person|null
     */
    public function getSpouse(Person $person)
    {
        if ($person->gender === 'male') {
            // Если персона - мужчина, ищем его жену
            return Person::whereHas('relationshipsAsSecond', function($query) use ($person) {
                $query->where('person1_id', $person->id)
                      ->where('type', 'spouse');
            })->first();
        } elseif ($person->gender === 'female') {
            // Если персона - женщина, ищем ее мужа
            return Person::whereHas('relationshipsAsFirst', function($query) use ($person) {
                $query->where('person2_id', $person->id)
                      ->where('type', 'spouse');
            })->first();
        }
        
        return null;
    }
    
    /**
     * Получить всех предков персоны до определенной глубины
     * 
     * @param Person $person Персона
     * @param int $maxDepth Максимальная глубина поиска
     * @return \Illuminate\Support\Collection
     */
    public function getAncestors(Person $person, int $maxDepth = 3)
    {
        $ancestors = collect();
        $this->findAncestorsRecursively($person, $ancestors, $maxDepth);
        return $ancestors;
    }
    
    /**
     * Рекурсивно находит предков персоны
     * 
     * @param Person $person Персона
     * @param \Illuminate\Support\Collection $ancestors Коллекция для хранения результатов
     * @param int $maxDepth Максимальная глубина поиска
     * @param int $currentDepth Текущая глубина
     */
    private function findAncestorsRecursively(Person $person, &$ancestors, int $maxDepth, int $currentDepth = 0)
    {
        if ($currentDepth >= $maxDepth) {
            return;
        }
        
        $parents = $this->getParents($person);
        
        foreach ($parents as $parent) {
            if (!$ancestors->contains('id', $parent->id)) {
                $ancestors->push($parent);
                $this->findAncestorsRecursively($parent, $ancestors, $maxDepth, $currentDepth + 1);
            }
        }
    }
    
    /**
     * Удалить связь между двумя персонами
     * 
     * @param Person $person1 Первая персона
     * @param Person $person2 Вторая персона
     * @param string|null $type Тип отношения (parent, spouse), если null - все типы
     * @return bool
     */
    public function removeRelationship(Person $person1, Person $person2, ?string $type = null): bool
    {
        $query = Relationship::where(function($q) use ($person1, $person2) {
            $q->where(function($q2) use ($person1, $person2) {
                $q2->where('person1_id', $person1->id)
                   ->where('person2_id', $person2->id);
            })->orWhere(function($q2) use ($person1, $person2) {
                $q2->where('person1_id', $person2->id)
                   ->where('person2_id', $person1->id);
            });
        });
        
        if ($type) {
            $query->where('type', $type);
        }
        
        return $query->delete() > 0;
    }
}