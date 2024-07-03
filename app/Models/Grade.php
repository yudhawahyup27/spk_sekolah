<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = ['grade'];
    public function student()
    {
        return $this->hasMany(Student::class);
    }
    public function year()
    {
        return $this->hasOne(Year::class);
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
