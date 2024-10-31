<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Setting_Time extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_group',
        'started_at',
        'ended_at',
        'notes'
    ];

    public function _group()
    {
        return $this->belongsTo(M_Group::class, 'id_group', 'id');
    }

    protected $casts = [
        'started_at' => 'datetime:Y-m-d H:i:s',
        'ended_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $table = 'setting_time';
}
