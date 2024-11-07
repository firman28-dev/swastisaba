<?php

namespace App\Http\Controllers;

use App\Models\M_Group;
use App\Models\M_District;
use App\Models\M_Zona;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Storage;

class User_Controller extends Controller
{
   
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    
    public function create()
    {
        $group = M_Group::all();
        $zona = M_Zona::all();
        $district = M_District::where('province_id', 13)->get();
        $sent = [
            'zona' => $zona,
            'group' => $group,
            'district' => $district
        ];
        return view('admin.users.create', $sent);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8',
            'id_group' => 'required',
            'id_zona' => 'nullable'
        ],
        [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar, silakan pilih username lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus minimal 8 karakter.',
            'id_group.required' => 'Role Akses harus dipilih.',
        ]);
        

        try{
            $user = new User();
            $user->username = $request->username;
            $user->password = $request->password;
            $user->id_group = $request->id_group;
            $user->id_zona = $request->id_zona;
            
            $user->save();
            // return $user;
            return redirect()->route('user.index')->with('success', 'Berhasil menambahkan data role akses');
        }
        catch(\Exception $e){
            return redirect()->route('user.create')->with('error', 'Gagal menambahkan data role akses. Silahkan coba lagi');

        }   
    }

    public function checkUsername(Request $request)
    {
        $zonaId = $request->input('zona_id');
        // $zona = M_Zona::find($zonaId);
        $zona = M_District::find($zonaId);
        $counter = 1;
        $kabkotaName = $zona->name;
        $usernameBase = 'Operator ' . $kabkotaName;

        do {
            $username = $usernameBase . ' ' . $counter;
            $existUser = User::where('username', 'like', '%' . $username . '%')->first();
        
            if ($existUser) {
                // Jika username sudah ada, tingkatkan counter
                $counter++;
            }
        } while ($existUser); // Ulangi sampai tidak ada username yang ditemukan
        
        // Jika tidak ada user, kembalikan username dengan counter yang unik
        return response()->json(['counter' => $counter, 'username' => $username]);
        // $existUser = User::where('username', 'like', '%' . $username . '%')->first();
        // if($existUser){
        //     return response()->json(['counter' => 0]);
        // }
        // else{
        //     return response()->json(['counter' => $username]);
        // }
        
    }

   
    public function show($id)
    {
        //
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $hashedPassword = 'sumbarprov';
        // return $hashedPassword;
        $user->update([
            'password' => $hashedPassword
        ]);
        \Log::info('Password for user ' . $user->id . ' has been reset to: ' . $hashedPassword);
        return redirect()->route('user.index')->with('success', 'Berhasil mereset password ke default');
    }

    public function resetSession($id){
        $userself = Auth::user();

        $user = User::findOrFail($id);
        if($userself->id != $user->id){
            $user->update([
                'session' => null
            ]);
            return redirect()->route('user.index')->with('success', 'Berhasil mereset session user');
        }
        else{
            return redirect()->route('user.index')->with('error', 'Tidak bisa menghapus session pribadi');

        }

    }

    public function editPhoto()
    {
        $user = Auth::user();
        $idUser = $user->id;
        return view('profile.change_photo', compact('idUser'));

    }

    public function updatedPhoto(Request $request)
    {
        $user = Auth::user();

        // Validasi foto yang diunggah
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Only allow image files, max 2MB
        ], [
            'photo.required' => 'Foto wajib diunggah.',
            'photo.image' => 'File yang diunggah harus berupa gambar.',
            'photo.mimes' => 'Hanya file JPEG, PNG, JPG, dan GIF yang diperbolehkan.',
            'photo.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        try {
            if ($user->photo) {
                $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/photo/' .$user->photo;
                // $oldPhotoPath = public_path('uploads/photo/' . $user->photo);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }

            $file = $request->file('photo'); 
            $fileName = time(). '_' . $file->getClientOriginalName();
            // $file->move(public_path('uploads/photo/'), $fileName);
            
            //untuk server
            $file->move($_SERVER['DOCUMENT_ROOT']. '/uploads/photo/', $fileName);

        
            $user->photo = $fileName;
            $user->save();
            return redirect()->route('user.profile')->with('success', 'Berhasil mengunggah foto.');

        } catch (\Throwable $th) {
            //throw $th;
        }
        

    }

    public function resetPhoto()
    {
        $user = Auth::user();

        if ($user->photo) {
            // Menghapus file dari server
            $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/photo/' .$user->photo;
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
            
            // Mengatur kolom foto menjadi null
            $user->photo = null;
            $user->save();
        }

        return redirect()->back()->with('success', 'Foto berhasil dihapus.');
    }


    
    public function edit($id)
    {
        $user = User::find($id);
        $group = M_Group::all();
        $zona = M_Zona::all();

        $sent =[
            'user' => $user,
            'group' => $group,
            'zona' => $zona
        ];
        return view('admin.users.edit', $sent);
    }

   
    public function update(Request $request, $id)
    {
        
    }

   
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data zona');

    }

    public function profile()
    {
        $user = Auth::user();
        $idUser = $user->id;
        $userFind = User::where('id',$idUser)->first();
        return view('profile.index', compact('userFind'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        $idUser = $user->id;
        $userFind = User::find($idUser);
        // return $userFind;
        return view('profile.edit', compact('userFind'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $idUser = $user->id;

        $request->validate([
            'username' => 'required|unique:users,username,' .$user->id,
            'name' => 'required',
            'email' => 'required|email',
            'id_zona' => 'nullable'
        ],
        [
            'username.required' => 'Username wajib diisi.',
            'name.required'=>'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'username.unique' => 'Username sudah terdaftar, silakan pakai username lain.',
            'id_group.required' => 'Role Akses harus dipilih.',
        ]);

        try{
            $user = User::find($idUser);
            $user->username = $request->username;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->id_zona = $request->id_zona;
            
            $user->save();
            // return $user;
            return redirect()->route('user.profile')->with('success', 'Berhasil mengubah data profile');
        }
        catch(\Exception $e){
            dd($e);
            return redirect()->route('user.edit')->with('error', 'Gagal mengubah data profile. Silahkan coba lagi');

        }   

    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $idUser = $user->id;

        $request->validate([
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password'
        ],
        [
            'password.required' => 'Password wajib diisi.',
            'confirm_password.required' => 'Confirm Password wajib diisi.',
            'new_password.min' => 'Password minimal 8 karakter',
            'confirm_password.same' => 'Password harus sama '
        ]);

        try{
            $user = User::find($idUser);
            $user->password = $request->new_password;
            
            $user->save();
            // return $user;
            return redirect()->route('user.profile')->with('success', 'Berhasil mengubah password baru');
        }
        catch(\Exception $e){
            return redirect()->route('user.profile')->with('error', 'Gagal mengubah password baru. Silahkan coba lagi');

        }   
    }

    public function onlyTrashed(){
        $trashedData = User::onlyTrashed()->get();
        return view('admin.trashed.user.trash',compact('trashedData'));
    }

    public function restore($id){
        $restore = User::withTrashed()->find($id);
        if($restore){
            $restore->restore();
            return redirect()->back()->with('success', 'Berhasil merestore data. Silahkan lihat di data user');
        }
        else{
            return redirect()->back()->with('error', 'Gagal merestore data');
        }
    }

    public function forceDelete($id){
        $category = User::withTrashed()->find($id);
        if($category){
            $category->forceDelete();
            return redirect()->back()->with('success', 'Berhasil menghapus permanen data');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus permanen data');
        }
    }
}
