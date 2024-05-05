<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use HasFactory;
    protected $table='member';
    protected $primaryKey='mid';
    protected $fillable=['name','dob','gender','email','contact_number','address','weight','height','photo','password'];

    protected $casts = [
        'password' => 'hashed',
    ];
}
