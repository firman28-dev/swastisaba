<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Trans_Narasi extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id_survey',
        'id_zona',
        'id_category',
        'path',
        'created_by',
        'updated_by'

    ];  
    
    protected $table = 'trans_narasi';
}
