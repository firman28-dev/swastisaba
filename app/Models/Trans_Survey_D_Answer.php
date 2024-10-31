<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Trans_Survey_D_Answer extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_survey',
        'id_zona',
        'id_category',
        'id_question',
        'id_option',
        'id_option_prov',
        'comment_prov',
        'id_option_pusat',
        'comment_pusat'

    ];  

    public function _zona()
    {
        return $this->belongsTo(M_Zona::class, 'id_zona');
    }

    public function _category()
    {
        return $this->belongsTo(M_Category::class, 'id_category');
    }
    public function _question()
    {
        return $this->belongsTo(M_Category::class, 'id_question');
    }

    public function _q_option()
    {
        return $this->belongsTo(M_Question_Option::class, 'id_option');
    }

    public function _q_option_prov()
    {
        return $this->belongsTo(M_Question_Option::class, 'id_option_prov');
    }

    public function _q_option_pusat()
    {
        return $this->belongsTo(M_Question_Option::class, 'id_option_pusat');
    }
    protected $table = 'trans_survey_d_answer';

}
