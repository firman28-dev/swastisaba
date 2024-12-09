<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trans_Kegiatan_Prov extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_survey',
        'name',
        'time',
        'participant',
        'result',
        'note',
        'path',
        'created_by',
        'updated_by',
    ];  

    protected $table = 'trans_kegiatan_prov';

}
