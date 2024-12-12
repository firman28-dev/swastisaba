<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trans_ODF_New extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_survey',
        'id_zona',
        'sum_subdistricts',
        'sum_villages',
        's_villages_stop_babs',
        'p_villages_stop_babs',
        'created_by',
        'updated_by',
    ];  

    protected $table = 'trans_odf_new';

}
