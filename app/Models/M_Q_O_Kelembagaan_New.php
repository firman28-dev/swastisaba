<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class M_Q_O_Kelembagaan_New extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $fillable = [
        'id_survey',
        'id_q_kelembagaan',
        'name',
        'score'
    ];  

    public function _question()
    {
        return $this->belongsTo(M_Q_Kelembagaan_New::class, 'id_q_kelembagaan', 'id');
    }

    protected $table = 'm_q_option_kelembagaan';
    protected $dates = ['deleted_at'];
}
