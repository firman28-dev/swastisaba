<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Trans_Kelembagaan_V2 extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id_survey',
        'id_zona',
        'id_q_kelembagaan',
        'id_opt_kelembagaan',
        'id_opt_kelembagaan_prov',
        'comment_prov',
        'id_opt_kelembagaan_pusat',
        'comment_pusat',
        'created_by',
        'updated_by'
    ];  

    public function _q_option()
    {
        return $this->belongsTo(M_Q_O_Kelembagaan_New::class, 'id_opt_kelembagaan');
    }

    public function _q_option_pusat()
    {
        return $this->belongsTo(M_Q_O_Kelembagaan_New::class, 'id_opt_kelembagaan_pusat');
    }

    public function _q_option_prov()
    {
        return $this->belongsTo(M_Q_O_Kelembagaan_New::class, 'id_opt_kelembagaan_prov');
    }

    protected $table = 'trans_kelembagaan_v2';
}
