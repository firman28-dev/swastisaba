<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BA_Pertatanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_survey',
        'id_zona',
        'id_category',
        'nama_pj_kabkota',
        'jb_pj_kabkota',
        'tim_verifikasi',
        'created_by',
        'updated_by'

    ];  
    protected $table = 'ba_pertatanan';
}
