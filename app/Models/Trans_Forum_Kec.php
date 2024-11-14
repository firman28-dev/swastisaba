<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Trans_Forum_Kec extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id_survey',
        'id_zona',
        'id_c_kelembagaan',
        'id_subdistrict',
        'f_distric',
        'no_sk',
        'expired_sk',
        'f_budget',
        's_address',
        'path_sk_f',
        'path_plan_f',
        'path_s',
        'path_budget',
        'answer_pusat',
        'comment_pusat',
        'answer_prov',
        'comment_prov',
        'created_by',   
        'updated_by',
        'updated_by_pusat',
        'updated_by_prov',

        
    ];  

    protected $table = 'trans_forum_kec';
}
