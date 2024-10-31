<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Trans_Kelembagaan_H extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_survey',
        'id_zona',
        'id_q_kelembagaan',
        'answer',
        'answer_prov',
        'comment_prov',
        'comment_pusat',
        'answer_pusat',


    ];  

    protected $table = 'trans_kelembagaan_h';
}
