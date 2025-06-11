<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'created_by',
        'full_name',
        'birth_date',
        'gender',
        'description',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Родственные связи, где этот человек является первым в паре
    public function relationshipsAsFirst(): HasMany
    {
        return $this->hasMany(Relationship::class, 'person1_id');
    }

    // Родственные связи, где этот человек является вторым в паре
    public function relationshipsAsSecond(): HasMany
    {
        return $this->hasMany(Relationship::class, 'person2_id');
    }

    // Получить родителей
    public function parents()
    {
        return Person::whereHas('relationshipsAsFirst', function($query) {
            $query->where('person2_id', $this->id)
                  ->where('type', 'parent');
        });
    }

    // Получить детей
    public function children()
    {
        return Person::whereHas('relationshipsAsSecond', function($query) {
            $query->where('person1_id', $this->id)
                  ->where('type', 'parent');
        });
    }

    // Получить мужа (если текущий человек - женщина)
    public function husband()
    {
        return Person::whereHas('relationshipsAsFirst', function($query) {
            $query->where('person2_id', $this->id)
                  ->where('type', 'spouse');
        });
    }

    // Получить жену (если текущий человек - мужчина)
    public function wife()
    {
        return Person::whereHas('relationshipsAsSecond', function($query) {
            $query->where('person1_id', $this->id)
                  ->where('type', 'spouse');
        });
    }

    // Получить всех супругов (для общего случая)
    public function spouses()
    {
        // Если текущий человек - мужчина, возвращаем его жен
        if ($this->gender === 'male') {
            return $this->wife();
        } 
        // Если текущий человек - женщина, возвращаем ее мужей
        elseif ($this->gender === 'female') {
            return $this->husband();
        } 
        // Если пол не указан, возвращаем всех супругов
        else {
            $husband = $this->husband();
            $wife = $this->wife();
            return $husband->union($wife);
        }
    }

    // Получить всех родственников (для отображения в дереве)
    public function getAllRelatives($depth = 3)
    {
        $relatives = collect();
        $this->getRelativesRecursive($this, $relatives, $depth);
        return $relatives;
    }

    private function getRelativesRecursive($person, &$relatives, $depth, $currentDepth = 0)
    {
        if ($currentDepth >= $depth || $relatives->contains('id', $person->id)) {
            return;
        }

        $relatives->push($person);

        // Добавляем родителей
        $parents = $person->parents()->get();
        foreach ($parents as $parent) {
            $this->getRelativesRecursive($parent, $relatives, $depth, $currentDepth + 1);
        }

        // Добавляем детей
        $children = $person->children()->get();
        foreach ($children as $child) {
            $this->getRelativesRecursive($child, $relatives, $depth, $currentDepth + 1);
        }

        // Добавляем супругов
        $spouses = $person->spouses()->get();
        foreach ($spouses as $spouse) {
            if (!$relatives->contains('id', $spouse->id)) {
                $relatives->push($spouse);
            }
        }
    }
}
