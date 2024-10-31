<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;



class M_Questions extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $fillable = [
        'id_survey',
        'id_category',
        'name',
        's_data',
        'd_operational'
    ];  

    public function _category()
    {
        return $this->belongsTo(M_Category::class, 'id_category', 'id');
    }
    public function _q_option()
    {
        return $this->hasMany(M_Question_Option::class, 'id_question', 'id');
    }

    public function _answers()
    {
        return $this->hasMany(Trans_Survey_D_Answer::class, 'id_question', 'id');
    }

    public function _doc_question()
    {
        return $this->hasMany(Doc_Question::class, 'id_question', 'id');
    }
    
    protected $table = 'm_questions';
    protected $dates = ['deleted_at'];

}
