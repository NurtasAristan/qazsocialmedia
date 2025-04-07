<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user_id',
        'from_person_id',
        'to_user_id',
        'to_person_id',
        'type',
        /*'direction',
        'confirmed',
        'metadata',*/
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function fromPerson()
    {
        return $this->belongsTo(Person::class, 'from_person_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function toPerson()
    {
        return $this->belongsTo(Person::class, 'to_person_id');
    }

    // Accessors

    public function from()
    {
        return $this->fromUser ?? $this->fromPerson;
    }

    public function to()
    {
        return $this->toUser ?? $this->toPerson;
    }
}
