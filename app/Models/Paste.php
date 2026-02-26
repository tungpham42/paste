<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Paste extends Model
{
    protected $fillable = [
        'user_id', 'slug', 'title', 'content', 'syntax',
        'visibility', 'password', 'expires_at'
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Automatically resolve routes by slug
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Scope to filter out expired pastes globally
    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where(function ($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            });
        });
    }
}
