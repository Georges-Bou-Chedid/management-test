<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Fleetrunnr\Permissions\traits\HasPermissions;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasPermissions;
    
   
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function accounts()
    {
        return $this->belongsToMany(Account::class);
    }

    public function getUserNameAttribute(): string 
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function Add($value)
{
    $this->accounts()->attach($value);
}


    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }
}
