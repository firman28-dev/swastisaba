<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Trans_Kegiatan extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id_survey',
        'id_zona',
        'id_c_kelembagaan',
        'id_kode',
        'name',
        'time',
        'participant',
        'result',
        'note',
        'path',
        'answer_prov',
        'answer_pusat',
        'comment_prov',
        'comment_pusat',
        'created_by',
        'updated_by',
        'updated_by_prov',
        'updated_by_pusat'
    ];  

    public function _c_kelembagaan()
    {
        return $this->belongsTo(M_C_Kelembagaan_New::class, 'id_c_kelembagaan');
    }

    protected $table = 'trans_kegiatan';
}