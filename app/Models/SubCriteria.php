<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCriteria extends Model
{
    use HasFactory;

    protected $table = 'sub_criteria';

    protected $fillable = ['criteria_id', 'name', 'code', 'value'];

    public function criteria()
    {
        return $this->hasOne(Criteria::class, 'criteria_id', 'id');
    }
}
