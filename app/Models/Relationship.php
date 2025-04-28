<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    use HasFactory;

    protected $fillable = [
        'person1_id',
        'person2_id',
        'type',
    ];

    public function person1()
    {
        return $this->belongsTo(Person::class, 'person1_id');
    }

    public function person2()
    {
        return $this->belongsTo(Person::class, 'person2_id');
    }
}
