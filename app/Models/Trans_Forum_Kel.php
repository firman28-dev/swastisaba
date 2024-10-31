<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Trans_Forum_Kel extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id_survey',
        'id_zona',
        'id_c_kelembagaan',
        'district',
        'subdistrict',
        'f_subdistrict',
        'no_sk',
        'expired_sk',
        'f_budget',
        's_address',
        'path_sk_f',
        'path_plan_f',
        'path_s',
        'path_budget',
        'created_by',   
        'updated_by'
    ];  

    protected $table = 'trans_forum_kel';
}
