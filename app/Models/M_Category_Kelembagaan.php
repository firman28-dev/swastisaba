<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class M_Category_Kelembagaan extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $fillable = [
        'id_survey',
        'name'
    ];  
    public function _q_kelembagaan(): HasMany
    {
        return $this->hasMany(M_Question_Kelembagaan::class, 'id_c_kelembagaan', 'id');
    }
    protected $table = 'm_category_kelembagaan';
    protected $dates = ['deleted_at'];

}
