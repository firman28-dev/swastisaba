<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trans_Gambaran_Prov extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_survey',
        'id_gambaran_prov', 
        'path',
        'created_by',
        'updated_by'
    ];  

    protected $table = 'trans_gambaran_prov';
}
