<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role->slug == 'organisasi') {
            $data = Laporan::where('organisasi_id', Auth::user()->organisasi->id)->get();
        } else {
            $data = Laporan::latest()->get();
        }
        return view('admin.master-data.laporan.index', [
            'title' => 'Laporan Kegiatan',
            'subtitle' => '',
            'active' => 'laporan',
            'datas' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->slug == 'organisasi') {
            $data = Organisasi::where('id', Auth::user()->organisasi->id)->get();
        } else {
            $data = Organisasi::latest()->get();
        }
        return view('admin.master-data.laporan.create', [
            'title' => 'Laporan Kegiatan',
            'subtitle' => 'Tambah Laporan',
            'active' => 'laporan',
            'organisasis' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'organisasi_id' => 'required',
            'nama_kegiatan' => 'required|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'tempat_kegiatan' => 'required',
            'tujuan_kegiatan' => 'required',
            'laporan_kegiatan' => 'required|mimes:pdf|max:2048', // File PDF maksimal 2MB

        ], [
            'organisasi_id.required' => 'Organisasi harus diisi!',
            'nama_kegiatan.required' => 'Nama kegiatan harus diisi!',
            'nama_kegiatan.max' => 'Nama kegiatan terlalu panjang!',
            'tanggal_pelaksanaan.required' => 'Tanggal pelaksanaan harus diisi!',
            'tanggal_pelaksanaan.date' => 'Tanggal pelaksanaan harus berupa tanggal!',
            'tempat_kegiatan.required' => 'Tempat kegiatan harus diisi!',
            'tujuan_kegiatan.required' => 'Tujuan kegiatan harus diisi!',
            'laporan_kegiatan.required' => 'Laporan kegiatan harus diupload!',
            'laporan_kegiatan.mimes' => 'Laporan kegiatan harus berupa file PDF!',
            'laporan_kegiatan.max' => 'Laporan kegiatan maksimal 2MB!',

        ]);

        // Upload file PDF
        $laporanFileName = $this->uploadFile($request->file('laporan_kegiatan'), 'laporan_kegiatan');


        // Simpan data laporan
        Laporan::create([
            'organisasi_id' => $request->input('organisasi_id'),
            'nama_kegiatan' => $request->input('nama_kegiatan'),
            'tanggal_pelaksanaan' => $request->input('tanggal_pelaksanaan'),
            'tempat_kegiatan' => $request->input('tempat_kegiatan'),
            'tujuan_kegiatan' => $request->input('tujuan_kegiatan'),
            'laporan_kegiatan' => $laporanFileName,

        ]);

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan kegiatan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('admin.master-data.laporan.show', [
            'title' => 'Laporan Kegiatan',
            'subtitle' => 'Detail Laporan',
            'active' => 'laporan',
            'data' => Laporan::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Auth::user()->slug == 'organisasi') {
            $data = Organisasi::where('id', Auth::user()->organisasi->id)->get();
        } else {
            $data = Organisasi::latest()->get();
        }
        return view('admin.master-data.laporan.edit', [
            'title' => 'Laporan Kegiatan',
            'subtitle' => 'Edit Laporan',
            'active' => 'laporan',
            'data' => Laporan::findOrFail($id),
            'organisasis' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'organisasi_id' => 'required',
            'nama_kegiatan' => 'required|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'tempat_kegiatan' => 'required',
            'tujuan_kegiatan' => 'required',
            'laporan_kegiatan' => 'nullable|mimes:pdf|max:2048',

        ], [
            'organisasi_id.required' => 'Organisasi harus diisi!',
            'nama_kegiatan.required' => 'Nama kegiatan harus diisi!',
            'nama_kegiatan.max' => 'Nama kegiatan terlalu panjang!',
            'tanggal_pelaksanaan.required' => 'Tanggal pelaksanaan harus diisi!',
            'tanggal_pelaksanaan.date' => 'Tanggal pelaksanaan harus berupa tanggal!',
            'tempat_kegiatan.required' => 'Tempat kegiatan harus diisi!',
            'tujuan_kegiatan.required' => 'Tujuan kegiatan harus diisi!',
            'laporan_kegiatan.mimes' => 'Laporan kegiatan harus berupa file PDF!',
            'laporan_kegiatan.max' => 'Laporan kegiatan maksimal 2MB!',

        ]);

        $laporan = Laporan::findOrFail($id);

        // Update file PDF jika ada
        if ($request->hasFile('laporan_kegiatan')) {
            $this->deleteFile($laporan->laporan_kegiatan);
            $laporan->laporan_kegiatan = $this->uploadFile($request->file('laporan_kegiatan'), 'laporan_kegiatan');
        }


        // Update data laporan
        $laporan->update([
            'organisasi_id' => $request->input('organisasi_id'),
            'nama_kegiatan' => $request->input('nama_kegiatan'),
            'tanggal_pelaksanaan' => $request->input('tanggal_pelaksanaan'),
            'tempat_kegiatan' => $request->input('tempat_kegiatan'),
            'tujuan_kegiatan' => $request->input('tujuan_kegiatan'),
        ]);

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan kegiatan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);

        // Hapus file PDF jika ada
        $this->deleteFile($laporan->laporan_kegiatan);

        $laporan->delete();

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan kegiatan berhasil dihapus!');
    }

    public function terima(Request $request, $id)
    {
        $laporan = Laporan::find($id);
        $laporan->status_pengajuan = 'terima';
        $laporan->save();
        return redirect()->route('admin.laporan.index')->with('success', 'laporan berhasil diterima!');

    }

    public function tolak(Request $request, $id)
    {
        $laporan = Laporan::find($id);
        $laporan->status_pengajuan = 'tolak';
        $laporan->pesan_pengajuan = $request->input('pesan_penolakan');
        $laporan->save();
        return redirect()->route('admin.laporan.index')->with('success', 'laporan berhasil ditolak!');
    }

    /**
     * Fungsi untuk mengupload file dan mengembalikan nama file yang disimpan.
     */
    private function uploadFile($file, $type)
    {
        $fileName = time() . '-' . $file->getClientOriginalName();
        $file->storeAs('public/uploads/laporan/' . $type, $fileName);
        return $fileName;
    }

    /**
     * Fungsi untuk menghapus file.
     */
    private function deleteFile($fileName)
    {
        if ($fileName) {
            Storage::delete('public/uploads/laporan/' . $fileName);
        }
    }
}
