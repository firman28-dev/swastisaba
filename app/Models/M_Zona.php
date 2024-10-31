<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class M_Zona extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $fillable = [
        'id_level',
        'name'
    ];  

    protected $table = 'm_zona';
    protected $dates = ['deleted_at'];
    public function _users()
    {
        return $this->hasMany(User::class, 'id_zona', 'id');
    }

    public function _generalData()
    {
        return $this->hasMany(M_General_Data::class, 'id_zona', 'id');
    }

    public function _transDAnswer()
    {
        return $this->hasMany(Trans_Survey_D_Answer::class, 'id_zona');
    }
}
