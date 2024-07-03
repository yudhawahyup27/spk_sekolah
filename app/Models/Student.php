<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'gender',
        'grade_id',
        'year_id'
    ];

    public function grade()
    {
        return $this->hasOne(Grade::class, 'id', 'grade_id');
    }

    public function year()
    {
        return $this->hasOne(Year::class, 'id', 'year_id');
    }
    public function candidate()
    {
        return $this->hasone(Candidate::class);
    }
   
    public function subCriteria()
    {
        return $this->hasOne(SubCriteria::class, 'id', 'sub_criteria_id');
    }
}
