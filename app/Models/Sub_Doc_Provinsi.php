<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Sub_Doc_Provinsi extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $fillable = [
        'id_survey',
        'id_c_doc_prov',
        'name',
    ];  

    public function _c_doc_prov()
    {
        return $this->belongsTo(Category_Doc_Provinsi::class, 'id_c_doc_prov', 'id');
    }

    protected $table = 'sub_doc_prov';
    protected $dates = ['deleted_at'];
}
