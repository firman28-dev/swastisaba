<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class M_Question_Kelembagaan extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $fillable = [
        'id_c_kelembagaan',
        'question',
        'opsi'
    ];  

    public function _c_kelembagaan(): BelongsTo
    {
        return $this->belongsTo(M_Category_Kelembagaan::class, 'id_c_kelembagaan', 'id');
    }

    protected $table = 'm_question_kelembagaan';
    protected $dates = ['deleted_at'];

}
