<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trans_Forum_KabKota extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_survey',
        'id_zona', 
        'sk_pembina',
        'renja',
        'created_by',
        'updated_by'
    ];  

    protected $table = 'trans_forum_kabkota';

}
