<?php

namespace App\Http\Controllers;

use App\Models\M_District;
use App\Models\M_Proposal;
use App\Models\Trans_ODF;
use App\Models\Trans_Survey;
use Auth;
use Illuminate\Http\Request;
use Session;

class Trans_ODF_KabKota_Controller extends Controller
{
    public function index(){
        $session_date = Session::get('selected_year');
        $user = Auth::user();
        $id_zona = $user->id_zona;

        $zona = M_District::find($id_zona);

        $odf = Trans_ODF::where('id_survey',$session_date)
            ->where('id_zona', $id_zona)
            ->first();

        return view('operator_kabkota.odf.index', compact('odf'));
    }

    public function create(){
        $user = Auth::user();
        $idZona = $user->id_zona;

        $name_zona = M_District::where('id', $idZona)->first();
        $proposal = M_Proposal::all();
        $sent = [
            'idZona' => $idZona,
            'nameZona' =>  $name_zona,
            'proposal' => $proposal
        ];

        return view('operator_kabkota.odf.create', $sent);
    }

    public function store(Request $request){

        $request->validate([
            'percentage' => 'required',
            'id_proposal' => 'required',
            'path' => 'nullable|mimes:pdf|max:10480',
        ],[
            'id_proposal.required' => 'Usulan wajib diisi',
            'percentage.required' => 'Persentase ODF wajib dipilih',
            'path.mimes' => 'Wajib Pdf',
            'path.max' => 'Ukuran Maksimal 10 MB',

        ]);

        $session_date = Session::get('selected_year');
        $user = Auth::user();
        $idZona = $user->id_zona;
        $files = $request->file('path'); 


        try{
            
            $odf = new Trans_ODF();
            $odf->id_survey = $session_date;
            $odf->id_zona = $idZona;
            $odf->id_proposal = $request->id_proposal;
            $odf->percentage = $request->percentage;
            if($files){
                $fileName = $idZona. '_ODF_' . $files->getClientOriginalName();
                $files->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_odf/', $fileName);
                $odf->path = $fileName;
            }
            else{
                $odf->path = null;
            }
            $odf->created_by = $user->id;
            $odf->updated_by = $user->id;

            $odf->save();
            return redirect()->route('odf.index')->with('success', 'Berhasil mengubah data ODF');

        }
        catch(\Throwable $e){
            throw $e;
            // return redirect()->back('g-data.createKabKota')->with('error', 'Gagal memperbaiki data umum. Silahkan coba lagi');
        }   
    }

    public function edit($id)
    {
        $user = Auth::user();
        $idZona = $user->id_zona;

        $name_zona = M_District::where('id', $idZona)->first();
        $trans_odf = Trans_ODF::find($id);
        $proposals = M_Proposal::all();
        $sent = [
            'idZona' => $idZona,
            'nameZona' =>  $name_zona,
            'transOdf' => $trans_odf,
            'proposals' => $proposals
        ];

        return view('operator_kabkota.odf.edit', $sent);
    }

    public function update(Request $request, $id){
        $request->validate([
            'percentage' => 'required',
            'id_proposal' => 'required',
            'path' => 'nullable|mimes:pdf|max:10480',
        ],[
            'id_proposal.required' => 'Usulan wajib diisi',
            'percentage.required' => 'Persentase ODF wajib dipilih',
            'path.mimes' => 'Wajib Pdf',
            'path.max' => 'Ukuran Maksimal 10 MB',

        ]);

        $session_date = Session::get('selected_year');
        $user = Auth::user();
        $idZona = $user->id_zona;
        // $files = $request->file('path'); 

        try{
            $odf = Trans_ODF::find($id);
            $odf->id_proposal = $request->id_proposal;
            $odf->percentage = $request->percentage;

            if ($request->hasFile('path')) {
                $path1 = $request->file('path');
                
                $fileName = $idZona . '_ODF_' . $path1->getClientOriginalName();
                $path1->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_odf/', $fileName);
                // $path1->move(public_path('uploads/doc_forum_kec/'), $fileName);
                if($odf->path){
                    $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_odf/' .$odf->path;
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                   
                }
                $odf->path = $fileName; // Simpan jika tidak null
            }
            $odf->updated_by = $user->id;

            $odf->save();
            return redirect()->route('odf.index')->with('success', 'Berhasil mengubah data ODF');

        }
        catch(\Throwable $e){
            throw $e;
            // return redirect()->back('g-data.createKabKota')->with('error', 'Gagal memperbaiki data umum. Silahkan coba lagi');
        }   
    }
}
