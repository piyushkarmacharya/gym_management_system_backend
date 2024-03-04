<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagee extends Model
{
    use HasFactory;
    protected $table='imagee';
    protected $fillable=['img'];
}
