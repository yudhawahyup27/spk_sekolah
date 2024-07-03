<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_id','sub_criteria_id'];

   

    public function subCriteria()
    {
        return $this->hasOne(SubCriteria::class, 'id', 'sub_criteria_id');
    }
}
