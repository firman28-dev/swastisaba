<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class M_Q_Kelembagaan_New extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $fillable = [
        'id_survey',
        'id_c_kelembagaan_v2',
        'indikator',
        'd_operational',
        's_data',
        'data_dukung'
    ];  

    public function _q_option()
    {
        return $this->hasMany(M_Q_O_Kelembagaan_New::class, 'id_q_kelembagaan', 'id');
    }

    protected $table = 'm_question_kelembagaan_new';
    protected $dates = ['deleted_at'];
}
