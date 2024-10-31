<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Trans_Doc_Kelembagaan extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id_survey',
        'id_zona',
        'id_q_kelembagaan',
        'path',
        'created_by',
        'updated_by'
    ];  

    protected $table = 'trans_doc_kelembagaan';

}
