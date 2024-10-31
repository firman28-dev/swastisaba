<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Trans_Survey extends Model
{
    use HasFactory, SoftDeletes, Notifiable;
    protected $fillable = [
        'trans_date',
    ];  

    protected $table = 'trans_survey_h';
    protected $dates = ['deleted_at'];

}
