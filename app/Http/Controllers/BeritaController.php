<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Menampilkan form untuk membuat berita baru.
     */
    public function create()
    {
        return view('admin.master-data.berita.create', [
            'title' => 'Create Berita',
            'subtitle' => 'Add New Berita',
            'active' => 'berita',
        ]);
    }

    /**
     * Menyimpan berita baru.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validasi gambar (max 2MB)
        ]);
        // Menyimpan cover image dan mendapatkan URL-nya
        $file = $request->file('cover');
        $fileName = time() . '-' . $file->getClientOriginalName();
        $file->storeAs('public/uploads/berita', $fileName);
        // Membuat berita baru
        Berita::create([
            'title' => $request->title,
            'cover' => $fileName, // Menyimpan path gambar cover
            'content' => $request->content,
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita has been added!');
    }

    /**
     * Menampilkan semua berita.
     */
    public function index()
    {
        return view('admin.master-data.berita.index', [
            'title' => 'Berita List',
            'active' => 'berita',
            'beritas' => Berita::latest()->get(),
        ]);
    }

    /**
     * Menampilkan form untuk mengedit berita.
     */
    public function edit($id)
    {
        return view('admin.master-data.berita.edit', [
            'title' => 'Edit Berita',
            'subtitle' => 'Edit Berita Details',
            'active' => 'berita',
            'berita' => Berita::findOrFail($id),
        ]);
    }

    /**
     * Memperbarui berita yang ada.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validasi gambar (max 2MB)
        ]);

        $berita = Berita::findOrFail($id);

        // Menyimpan cover image jika ada
        $coverPath = $berita->cover; // Jika tidak mengubah cover, tetap menggunakan yang lama
        if ($request->hasFile('cover')) {
            // Jika ada gambar baru, simpan gambar dan dapatkan URL-nya
            $coverPath = Berita::storeCover($request);
        }

        // Memperbarui berita
        $berita->update([
            'title' => $request->title,
            'cover' => $coverPath,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita has been updated!');
    }

    /**
     * Menghapus berita yang ada.
     */
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita has been deleted!');
    }
}
