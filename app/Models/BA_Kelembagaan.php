<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BA_Kelembagaan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_survey',
        'id_zona',
        'nama_pj_kabkota',
        'jb_pj_kabkota',
        'tim_verifikasi',
        'created_by',
        'updated_by'

    ];  
    protected $table = 'ba_kelembagaan';

}
