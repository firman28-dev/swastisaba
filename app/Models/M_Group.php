<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class M_Group extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
    ];  

    protected $table = 'm_group';
    protected $dates = ['deleted_at'];
    public function _users(): HasMany
    {
        return $this->hasMany(User::class, 'id_group', 'id');
    }
}
