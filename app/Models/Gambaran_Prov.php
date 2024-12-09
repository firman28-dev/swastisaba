<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gambaran_Prov extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_survey',
        'name',
    ]; 

    protected $table = 'prov_gambaran';

}
