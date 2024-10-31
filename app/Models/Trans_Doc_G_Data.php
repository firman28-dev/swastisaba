<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Trans_Doc_G_Data extends Model
{
    use HasFactory, Notifiable;
    
    protected $fillable = [
        'id_survey',
        'id_zona',
        'id_doc_g_data',
        'path',
        'is_prov',
        'is_pusat',
        'comment_pusat',
        'comment_prov'
    ];  

    public function _zona()
    {
        return $this->belongsTo(M_Zona::class, 'id_zona');
    }

    public function _doc()
    {
        return $this->belongsTo(M_Doc_General_Data::class, 'id_doc_g_data');
    }

    protected $table = 'trans_doc_general_data';


}
