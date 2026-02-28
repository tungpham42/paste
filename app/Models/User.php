<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'google_id',
        'is_pro',
        'is_admin',
        'avatar',
        'password'
    ];

    public function pastes()
    {
        return $this->hasMany(Paste::class);
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_admin' => 'boolean'
        ];
    }
}
