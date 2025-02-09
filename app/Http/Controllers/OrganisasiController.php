<?php

namespace App\Http\Controllers;

use App\Models\Organisasi;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menampilkan daftar organisasi
        return view('admin.master-data.organisasi.index', [
            'title' => 'Organisasi',
            'subtitle' => '',
            'active' => 'organisasi',
            'datas' => Organisasi::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form untuk menambahkan organisasi
        return view('admin.master-data.organisasi.create', [
            'title' => 'Organisasi',
            'subtitle' => 'Tambah Organisasi',
            'active' => 'organisasi',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $this->validate($request, [
            'name' => 'required|max:255', // Nama untuk user dan organisasi
            'ketua_umum' => 'required|max:255', // Nama untuk user dan organisasi
            'user_email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'tahun_berdiri' => 'required|integer',
        ], [
            'name.required' => 'Name is required!',
            'name.max' => 'Name is too long!',
            'user_email.required' => 'Email is required!',
            'user_email.email' => 'Please provide a valid email!',
            'password.required' => 'Password is required!',
            'password.min' => 'Password should be at least 8 characters!',
            'tahun_berdiri.required' => 'Year of establishment is required!',
        ]);

      
        // Ambil role berdasarkan slug
        $role = Role::where('slug', 'organisasi')->first();

        // Simpan data user yang terkait dengan organisasi
        $user = User::create([
            'name' => $request->input('name'), // Nama untuk user
            'email' => $request->input('user_email'),
            'password' => bcrypt($request->input('password')),
            'role_id' => $role->id,  // Menghubungkan user dengan role yang sesuai
            'no_hp' => $request->input('no_hp'),
        ]);

        // Simpan data organisasi
        Organisasi::create([
            'user_id' => $user->id,
            'tahun_berdiri' => $request->input('tahun_berdiri'),
            'ketua_umum'=> $request->input('ketua_umum')
        ]);

        return redirect()->route('admin.organisasi.index')->with('success', 'Organisasi dan user berhasil dibuat!');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Menampilkan detail organisasi
        $organisasi = Organisasi::findOrFail($id);
        return view('admin.master-data.organisasi.show', [
            'title' => 'Organisasi',
            'subtitle' => 'Detail Organisasi',
            'active' => 'organisasi',
            'data' => $organisasi,
        ]);
    }

    public function edit($id)
    {
        // Menampilkan detail organisasi
        $organisasi = Organisasi::findOrFail($id);
        return view('admin.master-data.organisasi.edit', [
            'title' => 'Organisasi',
            'subtitle' => 'edit Organisasi',
            'active' => 'organisasi',
            'data' => $organisasi,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, $id)
    {
        // Validasi data input
        $this->validate($request, [
            'name' => 'required|max:255', // Nama untuk user dan organisasi
            'user_email' => 'required|email|unique:users,email,' . $id, // Mengecualikan email pengguna yang sedang diedit
            'password' => 'nullable|min:8', // Password boleh kosong jika tidak diubah
            'tahun_berdiri' => 'required|integer',
            'ketua_umum' => 'required|max:255', // Nama untuk user dan organisasi
        ], [
            'name.required' => 'Name is required!',
            'name.max' => 'Name is too long!',
            'user_email.required' => 'Email is required!',
            'user_email.email' => 'Please provide a valid email!',
            'password.min' => 'Password should be at least 8 characters!',
            'tahun_berdiri.required' => 'Year of establishment is required!',
        ]);

        // Menangani upload file jika ada perubahan
        $organisasi = Organisasi::findOrFail($id);
        $user = $organisasi->user;

        // Memperbarui data user
        $user->update([
            'name' => $request->input('name'), // Nama untuk user
            'email' => $request->input('user_email'),
            'password' => $request->filled('password') ? bcrypt($request->input('password')) : $user->password, // Jika password kosong, jangan diubah
            'no_hp' => $request->input('no_hp'),
        ]);

  

        // Memperbarui data organisasi
        $organisasi->update([
            'tahun_berdiri' => $request->input('tahun_berdiri'),
            'ketua_umum' => $request->input('ketua_umum')
        ]);

        return redirect()->route('admin.organisasi.index')->with('success', 'Organisasi dan user berhasil diperbarui!');
    }


    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $organisasi = Organisasi::findOrFail($id);
        $user = $organisasi->user;
        // Hapus organisasi
        $organisasi->delete();

        // Hapus user terkait
        $user->delete();

        return redirect()->route('admin.organisasi.index')->with('success', 'Organisasi dan user berhasil dihapus!');
    }

}
