<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Trans_Gambaran_Kabkota extends Model
{
    use HasFactory,Notifiable;
    protected $fillable = [
        'id_zona',
        'id_survey',
        'id_gambaran_kabkota', 
        'path',
        'is_prov',
        'is_pusat',
        'comment_prov',
        'comment_pusat',
        'created_by'
    ];  

    protected $table = 'trans_gambaran_kabkota';
}
