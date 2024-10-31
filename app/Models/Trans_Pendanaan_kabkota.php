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
        'created_by'
    ];  

    protected $table = 'trans_pendanaan_kabkota';
}
