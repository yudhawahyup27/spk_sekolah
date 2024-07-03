<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;
    protected $fillable = ['year'];
    public function student()
    {
        return $this->hasMany(Student::class);
    }
    public function grade()
    {
        return $this->hasMany(Grade::class);
    }
}
