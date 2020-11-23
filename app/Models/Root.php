<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Root extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'root';
    protected $guarded = 'root';

    protected $fillable = [
        'username', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];
}
