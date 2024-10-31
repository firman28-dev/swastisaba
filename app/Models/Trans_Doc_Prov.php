<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Trans_Doc_Prov extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_survey',
        'id_sub_doc_prov',
        'path',
        'is_pusat',
        'comment_pusat'
    ];  

    protected $table = 'trans_doc_prov';

}
