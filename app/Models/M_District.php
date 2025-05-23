<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_District extends Model
{
    use HasFactory;
    protected $table = 'district';
    public function _transAnswers()
    {
        return $this->hasMany(Trans_Survey_D_Answer::class, 'id_zona', 'id');
    }

    public function _odf()
    {
        return $this->hasMany(Trans_ODF_New::class, 'id_zona', 'id');
    }
}
