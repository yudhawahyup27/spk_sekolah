<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hasil extends Model
{
    use HasFactory;

    protected $table = 'hasil'; // Sesuaikan dengan nama tabel baru 'hasil'

    protected $fillable = [
        'candidates_id',
        'category',
        'rank',
        'score',
        'created_at',
        'updated_at'
    ];

    // Tambahkan hubungan atau relasi ke model lain jika diperlukan
}
