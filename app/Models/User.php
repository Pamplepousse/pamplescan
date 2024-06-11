<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\VerifyEmail;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Define the fields that are allowed to be mass-assigned
    protected $fillable = ['name', 'gender', 'email', 'password', 'role'];

    // Hide these fields from arrays
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast attributes to native types
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Check if the user is a pending contributor
    public function isPendingContributor()
    {
        return $this->role === 'pending_contributor';
    }

    // Define the relationship to the Comment model
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    // Send email verification notification
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }
}