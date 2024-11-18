<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trans_Pendanaan_kabkota extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_zona',
        'id_survey',
        'id_pendanaan_kabkota', 
        'path',
        'is_prov',
        'is_pusat',
        'comment_prov',
        'comment_pusat',
        'created_by',
        'updated_by_pusat',
        'updated_by_prov'
    ];  

    protected $table = 'trans_pendanaan_kabkota';
}
