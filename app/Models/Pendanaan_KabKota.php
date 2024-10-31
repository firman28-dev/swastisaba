<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Pendanaan_KabKota extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'id_survey',
        'name',
    ];  

    // public function _question()
    // {
    //     return $this->belongsTo(M_Questions::class, 'id_question', 'id');
    // }

    protected $table = 'pendanaan_kabkota';
    protected $dates = ['deleted_at'];
}
