<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trans_ODF extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_survey',
        'id_zona',
        'percentage',
        'path',
        'id_proposal',
        'percentage_prov',
        'id_proposal_prov',
        'created_by',
        'updated_by',
        'updated_by_prov'
    ];  

    public function _proposal()
    {
        return $this->belongsTo(M_Proposal::class, 'id_proposal');
    }

    public function _proposal_prov()
    {
        return $this->belongsTo(M_Proposal::class, 'id_proposal_prov');
    }

    protected $table = 'trans_odf_percentage';

}
