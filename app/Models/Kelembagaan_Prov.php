<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelembagaan_Prov extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_survey',
        'name',
    ];  

    protected $table = 'prov_kelembagaan';
}
