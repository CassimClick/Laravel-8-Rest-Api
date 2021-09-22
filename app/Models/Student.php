<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Student extends Model
{
    use HasApiTokens, HasFactory;
    protected $table = 'student';

    public $fillable = ['name', 'email', 'mobile', 'password'];
}