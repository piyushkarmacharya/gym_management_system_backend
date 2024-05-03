<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceQr extends Model
{
    use HasFactory;
    protected $table="attendance_qr";
    protected $primarykey="id";
    protected $fillable=['qrstr'];
}
