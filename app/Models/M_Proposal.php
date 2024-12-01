<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Proposal extends Model
{
    use HasFactory;

    public function _odf()
    {
        return $this->hasMany(Trans_ODF::class, 'id_proposal', 'id');
    }

    public function _odf_prov()
    {
        return $this->hasMany(Trans_ODF::class, 'id_proposal_prov', 'id');
    }
    
    protected $table = 'm_proposal';
}
