<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'nilai_akademik', 'gambar_kriteria'];

    public function student()
    {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }
    public function criteria()
    {
        return $this->hasMany(Criteria::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
}
