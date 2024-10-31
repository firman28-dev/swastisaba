<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class M_Question_Option extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'id_survey',
        'id_question',
        'name',
        'score'
    ];  

    public function _question()
    {
        return $this->belongsTo(M_Questions::class, 'id_question', 'id');
    }


    public function _option_prov()
    {
        return $this->hasMany(Trans_Survey_D_Answer::class, 'id_option_prov', 'id');
    }

    public function _option_pusat()
    {
        return $this->hasMany(Trans_Survey_D_Answer::class, 'id_option_pusat', 'id');
    }

    public function _option_kabkota()
    {
        return $this->hasMany(Trans_Survey_D_Answer::class, 'id_option', 'id');
    }

    

    protected $table = 'm_question_options';
    protected $dates = ['deleted_at'];
    
}
