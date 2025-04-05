<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Order; // Add this import

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'photo', 'role', 'status'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    // Add these relationships
  // Add these relationships



  public function orders()
  {
      return $this->hasMany(Order::class);
  }

  public function reviews()
  {
      return $this->hasMany(Review::class);
  }
}

