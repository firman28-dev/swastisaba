<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionPostest extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'id_survey',
        'question',
        'opt_a',
        'opt_b',
        'opt_c',
        'opt_d',
        'opt_correct',
        'created_by',
        'updated_by',
    ];  

    protected $table = 'question_postest';
}
