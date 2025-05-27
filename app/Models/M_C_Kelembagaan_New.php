<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class M_C_Kelembagaan_New extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $fillable = [
        'id_survey',
        'name',
        'is_status'

    ];  
    public function _questions()
    {
        return $this->hasMany(M_Q_Kelembagaan_New::class, 'id_c_kelembagaan_v2');
    }
    protected $table = 'm_category_kelembagaan_new';
    protected $dates = ['deleted_at'];
}
