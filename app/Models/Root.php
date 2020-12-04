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
        'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    public function getRoot(){
        return Root::all()->first();
    }
}
