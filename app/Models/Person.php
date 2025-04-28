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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parents()
    {
        return $this->belongsToMany(Person::class, 'relationships', 'person2_id', 'person1_id')
            ->wherePivot('type', 'parent');
    }

    public function children()
    {
        return $this->belongsToMany(Person::class, 'relationships', 'person1_id', 'person2_id')
            ->wherePivot('type', 'parent');
    }

    public function spouses()
    {
        return $this->belongsToMany(Person::class, 'relationships', 'person1_id', 'person2_id')
            ->wherePivot('type', 'spouse');
    }
}
