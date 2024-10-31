<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class M_Category extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'id_survey',
        'name'
    ];  

    public function _question(): HasMany
    {
        return $this->hasMany(M_Questions::class, 'id_category', 'id');
    }

    public function _transDAnswer()
{
    return $this->hasMany(Trans_Survey_D_Answer::class, 'id_category');
}

    protected $table = 'm_category';
    protected $dates = ['deleted_at'];
}
