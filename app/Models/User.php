<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

protected $fillable = ['name','gender', 'email', 'password', 'role'];


    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function isPendingContributor()
    {
        return $this->role === 'pending_contributor';
    }
    public function comments() {
    return $this->hasMany(Comment::class);
}
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
