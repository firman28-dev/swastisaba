<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BA_General extends Model
{
    use HasFactory;
     protected $fillable = [
        'ba_bappeda_prov_id',
        'ba_dinkes_prov_id',
        'zona_id',
        'skpd_id',
        'nama_pj_skpd',
        'jb_pj_skpd',
        'nama_pj_bappeda_kabkota',
        'jb_pj_bappeda_kabkota',
        'nama_pj_dinkes_kabkota',
        'jb_pj_dinkes_kabkota',
        'nama_pj_forum',
        'jb_pj_forum',
        'created_by',
        'updated_by',
        'periode_id'

    ];  

    public function _skpd()
    {
        return $this->belongsTo(SKPD::class, 'skpd_id', 'id');
    }

    public function _bappeda_prov()
    {
        return $this->belongsTo(BA_Bappeda::class, 'ba_bappeda_prov_id', 'id');
    }

    public function _dinkes_prov()
    {
        return $this->belongsTo(BA_Dinkes::class, 'ba_dinkes_prov_id', 'id');
    }
    protected $table = 'ba_general';
}
