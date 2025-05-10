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
        'achievement',
        'comment',
        'id_option_prov',
        'comment_prov',
        'comment_detail_prov',
        'status_verifikasi',
        'id_option_pusat',
        'comment_pusat',
        'created_by',
        'updated_by',
        'updated_by_prov',
        'updated_by_pusat'
    ];  

    public function _district()
    {
        return $this->belongsTo(M_District::class, 'id_zona');
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
