<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'group_id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_user');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
