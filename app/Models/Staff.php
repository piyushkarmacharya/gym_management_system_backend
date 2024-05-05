<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    use HasFactory;
    protected $table="staff";
    protected $fillable=["first name","last name","gender","address","email","password","phone number"];

    protected $casts = [
        
        'password' => 'hashed',
    ];
}
