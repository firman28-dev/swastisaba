<?php

namespace App\Http\Controllers;

use App\Models\M_Group;
use App\Models\Setting_Time;
use Illuminate\Http\Request;

class Setting_Time_Controller extends Controller
{
    
    public function index()
    {
        $group = M_Group::whereNot('id', 2)->get();
        $schedule = Setting_Time::all();
        $sent = [
            'group' => $group,
            'schedule' => $schedule
        ];
        return view('admin.schedule.index', $sent);
    }

    public function create($id)
    {
        $idGroup = M_Group::find($id);
        // return $idGroup;
        return view('admin.schedule.create' , compact('idGroup'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'group' => 'required',
            'started_at' => 'required',
            'ended_at' => 'required',
            'notes' => 'required'
        ],[
            'started_at.required' => 'Jadwal Awal wajib diisi',
            'ended_at.required' => 'Jadwal Akhir wajib diisi',
            'notes.required' => 'Keterangan wajib diisi'
        ]);

        $group = $request->group;

        try{
            $schedule = Setting_Time::where('id_group', $group)->first();
            // return $schedule;
            if($schedule){
                
            }
            else{
                $sch = new Setting_Time();
                $sch->started_at = strtotime($request->started_at);
                $sch->ended_at = strtotime($request->ended_at);
                $sch->notes = $request->notes;

                $sch->id_group = $group;
                $sch->save();
            }
            
            return redirect()->route('schedule.index')->with('success', 'Berhasil menambahkan data jadwal verifikasi');
        }
        catch(\Exception $e){
            dd($e);
            return redirect()->route('schedule.create')->with('error', 'Gagal menambahkan data jadwal verifikasi. Silahkan coba lagi');

        }   
        
    }

   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $schedule = Setting_Time::find($id);
        // return $schedule;
        return view('admin.schedule.edit' , compact('schedule'));
    }

    public function update(Request $request, $id)
    {
        // date_default_timezone_set('Asia/Jakarta');
        $request->validate([
            'started_at' => 'required',
            'ended_at' => 'required',
            'notes' => 'required'
        ], [
            'started_at.required' => 'Waktu awal wajib diisi',
            'ended_at.required' => 'Waktu akhir wajib diisi',
            'notes.required' => 'Keterangan wajib diisi'

        ]);

        try{
            $schedule = Setting_Time::find($id);
            // return $schedule;
            $schedule->started_at = strtotime( $request->started_at);
            $schedule->ended_at = strtotime($request->ended_at);
            $schedule->notes = $request->notes;


            $schedule->save();
            return redirect()->route('schedule.index')->with('success', 'Berhasil mengubah data jadwal verifikasi');
        }
        catch(\Exception $e){
            dd($e);
            // return redirect()->back('schedule.create')->with('error', 'Gagal mengubah data jadwal verifikasi. Silahkan coba lagi');

        }
    }

    public function destroy($id)
    {
        //
    }
}
