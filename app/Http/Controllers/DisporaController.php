<?php

namespace App\Http\Controllers;

use App\Models\Diaspora;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class DisporaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menampilkan daftar diaspora
        $dispora = Role::where('slug', 'dispora')->first();
        return view('admin.master-data.dispora.index', [
            'title' => 'Kabid',
            'subtitle' => '',
            'active' => 'dispora',
            'datas' => User::where('role_id', $dispora->id)->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form untuk menambahkan diaspora
        return view('admin.master-data.dispora.create', [
            'title' => 'Kabid',
            'subtitle' => 'Tambah Kabid',
            'active' => 'dispora',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $this->validate($request, [
            'name' => 'required|max:255', // Nama untuk user dan diaspora
            'user_email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'no_hp' => 'required|string',
        ], [
            'name.required' => 'Name is required!',
            'name.max' => 'Name is too long!',
            'user_email.required' => 'Email is required!',
            'user_email.email' => 'Please provide a valid email!',
            'password.required' => 'Password is required!',
            'password.min' => 'Password should be at least 8 characters!',
            'no_hp.required' => 'Phone number is required!',
        ]);

        // Ambil role berdasarkan slug 'diaspora'
        $role = Role::where('slug', 'dispora')->first();

        // Simpan data user
        $user = User::create([
            'name' => $request->input('name'), // Nama untuk user
            'email' => $request->input('user_email'),
            'password' => bcrypt($request->input('password')),
            'role_id' => $role ? $role->id : null,  // Menghubungkan user dengan role diaspora
            'no_hp' => $request->input('no_hp'),
        ]);
        // Simpan data diaspora (jika diperlukan, jika ada model atau tabel diaspora)
      

        return redirect()->route('admin.dispora.index')->with('success', 'Diaspora dan user berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Menampilkan detail diaspora
        $diaspora = User::findOrFail($id);
        return view('admin.master-data.dispora.show', [
            'title' => 'Kabid',
            'subtitle' => 'Detail Kabid',
            'active' => 'dispora',
            'data' => $diaspora,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Menampilkan form untuk mengedit diaspora
        $diaspora = User::findOrFail($id);
        return view('admin.master-data.dispora.edit', [
            'title' => 'Diaspora',
            'subtitle' => 'Edit Diaspora',
            'active' => 'dispora',
            'data' => $diaspora,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data input
        $this->validate($request, [
            'name' => 'required|max:255', // Nama untuk user dan diaspora
            'user_email' => 'required|email|unique:users,email,' . $id, // Mengecualikan email pengguna yang sedang diedit
            'password' => 'nullable|min:8', // Password boleh kosong jika tidak diubah
            'no_hp' => 'required|string',
        ], [
            'name.required' => 'Name is required!',
            'name.max' => 'Name is too long!',
            'user_email.required' => 'Email is required!',
            'user_email.email' => 'Please provide a valid email!',
            'password.min' => 'Password should be at least 8 characters!',
            'no_hp.required' => 'Phone number is required!',
        ]);

        // Menangani perubahan user
        $user = User::find($id);

        // Memperbarui data user
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('user_email'),
            'password' => $request->filled('password') ? bcrypt($request->input('password')) : $user->password,
            'no_hp' => $request->input('no_hp'),
        ]);

        // Memperbarui data diaspora
       

        return redirect()->route('admin.dispora.index')->with('success', 'Diaspora dan user berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $diaspora = User::findOrFail($id);


        return redirect()->route('admin.dispora.index')->with('success', 'Diaspora dan user berhasil dihapus!');
    }
}
