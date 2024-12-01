<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_General_Data extends Model
{
    use HasFactory;
    protected $fillable = [
        'provinsi',
        'id_zona',
        'nama_wako_bup',
        'alamat_kantor',
        'nama_pembina',
        'nama_forum',
        'nama_ketua_forum',
        'alamat_kantor_forum',
        // 'doc_surat_minat',
        // 'doc_odf',
        // 'doc_akses_jamban',
    ];  

    public function _zona()
    {
        return $this->belongsTo(M_District::class, 'id_zona', 'id');
    }

    protected $table = 'm_general_data';
}
