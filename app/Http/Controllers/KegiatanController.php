<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Organisasi;
use App\Models\PeriodePengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->slug == 'organisasi') {
            $data = Kegiatan::where('organisasi_id', Auth::user()->organisasi->id)->get();
        }
        else
        {
            $data = Kegiatan::latest()->get();
        }
        return view('admin.master-data.kegiatan.index', [
            'title' => 'Kegiatan',
            'subtitle' => '',
            'active' => 'kegiatan',
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
        }
        else
        {
            $data = Organisasi::latest()->get();
        }
        return view('admin.master-data.kegiatan.create', [
            'title' => 'Kegiatan',
            'subtitle' => 'Tambah Kegiatan',
            'active' => 'kegiatan',
            'organisasis' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, 
            [
                'organisasi_id' => 'required',
                'tanggal_pengajuan' => 'required|date',
                'nama_kegiatan' => 'required|max:255',
                'deskripsi_kegiatan' => 'required',
                'tanggal_pelaksanaan' => 'required|date',
                'surat_undangan' => 'required|mimes:pdf|max:2048', // File PDF maksimal 2MB
            ],
            [
                'organisasi_id.required' => 'Organisasi harus diisi!',
                'tanggal_pengajuan.required' => 'Tanggal pengajuan harus diisi!',
                'tanggal_pengajuan.date' => 'Tanggal pengajuan harus berupa tanggal!',
                'nama_kegiatan.required' => 'Nama kegiatan harus diisi!',
                'nama_kegiatan.max' => 'Nama kegiatan terlalu panjang!',
                'deskripsi_kegiatan.required' => 'Deskripsi kegiatan harus diisi!',
                'tanggal_pelaksanaan.required' => 'Tanggal pelaksanaan harus diisi!',
                'tanggal_pelaksanaan.date' => 'Tanggal pelaksanaan harus berupa tanggal!',
                'skala_kegiatan.required' => 'Skala kegiatan harus diisi!',
                'skala_kegiatan.in' => 'Skala kegiatan tidak valid!',
                'surat_undangan.required' => 'Surat undangan harus diisi!',
                'surat_undangan.mimes' => 'Surat undangan harus berupa file PDF!',
                'surat_undangan.max' => 'Surat undangan maksimal 2MB!',
            ]
        );

        // Upload file surat undangan
        if ($request->hasFile('surat_undangan')) {
            $file = $request->file('surat_undangan');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('public/uploads/kegiatan/surat-undangan', $fileName);
        }

        // Simpan data kegiatan
        Kegiatan::create([
            'organisasi_id' => $request->input('organisasi_id'),
            'tanggal_pengajuan' => $request->input('tanggal_pengajuan'),
            'nama_kegiatan' => $request->input('nama_kegiatan'),
            'deskripsi_kegiatan' => $request->input('deskripsi_kegiatan'),
            'tanggal_pelaksanaan' => $request->input('tanggal_pelaksanaan'),
            'skala_kegiatan' => $request->input('skala_kegiatan'),
            'surat_undangan' => $fileName,
            'status_pengajuan' => 'periksa', // Default status pengajuan
        ]);

        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        return view('admin.master-data.kegiatan.show', [
            'title' => 'Kegiatan',
            'subtitle' => 'Detail Kegiatan',
            'active' => 'kegiatan',
            'data' => Kegiatan::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Auth::user()->slug == 'organisasi') {
            $data = Organisasi::where('id', Auth::user()->organisasi->id)->get();
        }
        else
        {
            $data = Organisasi::latest()->get();
        }
        return view('admin.master-data.kegiatan.edit', [
            'title' => 'Kegiatan',
            'subtitle' => 'Edit Kegiatan',
            'active' => 'kegiatan',
            'data' => Kegiatan::findOrFail($id),
            'organisasis' => $data,
        ]);
    }

    public function terima(Request $request, $id)
    {
        $proposal = Kegiatan::find($id);
        $proposal->status_pengajuan = 'terima';
        $proposal->relevansi = $request->input('relevansi');
        $proposal->save();
        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil diterima!');

    }

    public function tolak(Request $request, $id)
    {
        $proposal = Kegiatan::find($id);
        $proposal->status_pengajuan = 'tolak';
        $proposal->pesan_pengajuan = $request->input('pesan_penolakan');
        $proposal->save();
        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil ditolak!');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, 
            [
                'organisasi_id' => 'required',
                'tanggal_pengajuan' => 'required|date',
                'nama_kegiatan' => 'required|max:255',
                'deskripsi_kegiatan' => 'required',
                'tanggal_pelaksanaan' => 'required|date',
                'surat_undangan' => 'nullable|mimes:pdf|max:2048', // File PDF maksimal 2MB
            ],
            [
                'organisasi_id.required' => 'Organisasi harus diisi!',
                'tanggal_pengajuan.required' => 'Tanggal pengajuan harus diisi!',
                'tanggal_pengajuan.date' => 'Tanggal pengajuan harus berupa tanggal!',
                'nama_kegiatan.required' => 'Nama kegiatan harus diisi!',
                'nama_kegiatan.max' => 'Nama kegiatan terlalu panjang!',
                'deskripsi_kegiatan.required' => 'Deskripsi kegiatan harus diisi!',
                'tanggal_pelaksanaan.required' => 'Tanggal pelaksanaan harus diisi!',
                'tanggal_pelaksanaan.date' => 'Tanggal pelaksanaan harus berupa tanggal!',
                'skala_kegiatan.required' => 'Skala kegiatan harus diisi!',
                'skala_kegiatan.in' => 'Skala kegiatan tidak valid!',
                'surat_undangan.mimes' => 'Surat undangan harus berupa file PDF!',
                'surat_undangan.max' => 'Surat undangan maksimal 2MB!',
            ]
        );

        $kegiatan = Kegiatan::findOrFail($id);

        // Upload file surat undangan jika ada
        if ($request->hasFile('surat_undangan')) {
            $file = $request->file('surat_undangan');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('public/uploads/kegiatan/surat-undangan', $fileName);

            // Hapus file lama jika ada
            if ($kegiatan->surat_undangan) {
                Storage::delete('public/uploads/kegiatan/surat-undangan/' . $kegiatan->surat_undangan);
            }

            $kegiatan->surat_undangan = $fileName;
        }

        // Update data kegiatan
        $kegiatan->update([
            'organisasi_id' => $request->input('organisasi_id'),
            'tanggal_pengajuan' => $request->input('tanggal_pengajuan'),
            'nama_kegiatan' => $request->input('nama_kegiatan'),
            'deskripsi_kegiatan' => $request->input('deskripsi_kegiatan'),
            'tanggal_pelaksanaan' => $request->input('tanggal_pelaksanaan'),
            'skala_kegiatan' => $request->input('skala_kegiatan'),
            'status_pengajuan' => 'periksa', // Default status pengajuan
        ]);

        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        // Hapus file surat undangan jika ada
        if ($kegiatan->surat_undangan) {
            Storage::delete('public/uploads/kegiatan/surat-undangan/' . $kegiatan->surat_undangan);
        }

        $kegiatan->delete();

        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil dihapus!');
    }
}