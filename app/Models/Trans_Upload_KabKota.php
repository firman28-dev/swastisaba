<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Trans_Upload_KabKota extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_survey',
        'id_zona',
        'id_category',
        'id_question',
        'id_doc_question',
        'file_path'

    ];  
    public function _doc_question()
    {
        return $this->belongsTo(Doc_Question::class, 'id_doc_question', 'id');
    }
    protected $table = 'trans_upload_kabkota';

}
