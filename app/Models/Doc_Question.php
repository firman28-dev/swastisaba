<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Doc_Question extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'id_survey',
        'id_question',
        'name',
        'ket'
    ];  

    public function _question()
    {
        return $this->belongsTo(M_Questions::class, 'id_question', 'id');
    }

    protected $table = 'doc_question';
    protected $dates = ['deleted_at'];
}
