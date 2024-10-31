<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class M_Level extends Model
{
    use HasFactory,Notifiable,SoftDeletes;

    protected $fillable = [
        'name',
    ];  

    protected $table = 'm_level';
    protected $dated = ['deleted_at'];

}
