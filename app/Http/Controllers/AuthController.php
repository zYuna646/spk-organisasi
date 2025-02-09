<?php

namespace App\Http\Controllers;

use App\Models\Organisasi;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function submit(Request $request)
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

        return redirect()->route('login')->with('success', 'Berhasil Mendaftar!');
    }
}
