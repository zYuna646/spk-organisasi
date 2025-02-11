<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role->slug == 'organisasi') {
            $data = Proposal::where('organisasi_id', Auth::user()->organisasi->id)->get();
        } else {
            $data = Proposal::latest()->get();
        }
        return view('admin.master-data.proposal.index', [
            'title' => 'Proposal',
            'subtitle' => '',
            'active' => 'proposal',
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
        return view('admin.master-data.proposal.create', [
            'title' => 'Proposal',
            'subtitle' => 'Tambah Proposal',
            'active' => 'proposal',
            'organisasis' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'organisasi_id' => 'required',
                'nama_kegiatan' => 'required|max:255',
                'deskripsi_kegiatan' => 'required',
                'tanggal_pelaksanaan' => 'required|date',
                'tanggal_pengajuan' => 'required|date',
                'kebutuhan_dana' => 'required|numeric',
                'nomor_rekening' => 'required|max:255',
                'nama_rekening' => 'required|max:255',
                'nama_bank' => 'required|max:255',
                'link_drive' => 'required|url',
            ],
            [
                'organisasi_id.required' => 'Organisasi harus diisi!',
                'nama_kegiatan.required' => 'Nama kegiatan harus diisi!',
                'nama_kegiatan.max' => 'Nama kegiatan terlalu panjang!',
                'deskripsi_kegiatan.required' => 'Deskripsi kegiatan harus diisi!',
                'tanggal_pelaksanaan.required' => 'Tanggal pelaksanaan harus diisi!',
                'tanggal_pelaksanaan.date' => 'Tanggal pelaksanaan harus berupa tanggal!',
                'tanggal_pengajuan.required' => 'Tanggal pengajuan harus diisi!',
                'tanggal_pengajuan.date' => 'Tanggal pengajuan harus berupa tanggal!',
                'skala_kegiatan.required' => 'Skala kegiatan harus diisi!',
                'skala_kegiatan.in' => 'Skala kegiatan tidak valid!',
                'kebutuhan_dana.required' => 'Kebutuhan dana harus diisi!',
                'kebutuhan_dana.numeric' => 'Kebutuhan dana harus berupa angka!',
                'nomor_rekening.required' => 'Nomor rekening harus diisi!',
                'nomor_rekening.max' => 'Nomor rekening terlalu panjang!',
                'nama_rekening.required' => 'Nama rekening harus diisi!',
                'nama_rekening.max' => 'Nama rekening terlalu panjang!',
                'nama_bank.required' => 'Nama bank harus diisi!',
                'nama_bank.max' => 'Nama bank terlalu panjang!',
                'link_drive.required' => 'Link drive harus diisi!',
                'link_drive.url' => 'Link drive harus berupa URL yang valid!',
            ]
        );

        // dd($request->all());
        // Simpan data proposal
        Proposal::create([
            'organisasi_id' => $request->input('organisasi_id'),
            'nama_kegiatan' => $request->input('nama_kegiatan'),
            'deskripsi_kegiatan' => $request->input('deskripsi_kegiatan'),
            'tanggal_pelaksanaan' => $request->input('tanggal_pelaksanaan'),
            'tanggal_pengajuan' => $request->input('tanggal_pengajuan'),
            'skala_kegiatan' => $request->input('skala_kegiatan'),
            'kebutuhan_dana' => $request->input('kebutuhan_dana'),
            'nomor_rekening' => $request->input('nomor_rekening'),
            'nama_rekening' => $request->input('nama_rekening'),
            'nama_bank' => $request->input('nama_bank'),
            'link_drive' => $request->input('link_drive'),
            'status_pengajuan' => 'periksa', // Default status pengajuan
        ]);

        return redirect()->route('admin.proposal.index')->with('success', 'Proposal berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('admin.master-data.proposal.show', [
            'title' => 'Proposal',
            'subtitle' => 'Detail Proposal',
            'active' => 'proposal',
            'data' => Proposal::findOrFail($id),
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

        return view('admin.master-data.proposal.edit', [
            'title' => 'Proposal',
            'subtitle' => 'Edit Proposal',
            'active' => 'proposal',
            'data' => Proposal::findOrFail($id),
            'organisasis' => $data,
        ]);
    }

    public function terima(Request $request, $id)
    {
        $proposal = Proposal::find($id);
        $proposal->status_pengajuan = 'terima';
        $proposal->relevansi = $request->input('relevansi');
        $proposal->save();
        return redirect()->route('admin.proposal.index')->with('success', 'Proposal berhasil diterima!');

    }

    public function tolak(Request $request, $id)
    {
        $proposal = Proposal::find($id);
        $proposal->status_pengajuan = 'tolak';
        $proposal->pesan_pengajuan = $request->input('pesan_penolakan');
        $proposal->save();
        return redirect()->route('admin.proposal.index')->with('success', 'Proposal berhasil ditolak!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'organisasi_id' => 'required',
                'nama_kegiatan' => 'required|max:255',
                'deskripsi_kegiatan' => 'required',
                'tanggal_pelaksanaan' => 'required|date',
                'tanggal_pengajuan' => 'required|date',
                'kebutuhan_dana' => 'required|numeric',
                'nomor_rekening' => 'required|max:255',
                'nama_rekening' => 'required|max:255',
                'nama_bank' => 'required|max:255',
                'link_drive' => 'required|url',
            ],
            [
                'organisasi_id.required' => 'Organisasi harus diisi!',
                'nama_kegiatan.required' => 'Nama kegiatan harus diisi!',
                'nama_kegiatan.max' => 'Nama kegiatan terlalu panjang!',
                'deskripsi_kegiatan.required' => 'Deskripsi kegiatan harus diisi!',
                'tanggal_pelaksanaan.required' => 'Tanggal pelaksanaan harus diisi!',
                'tanggal_pelaksanaan.date' => 'Tanggal pelaksanaan harus berupa tanggal!',
                'tanggal_pengajuan.required' => 'Tanggal pengajuan harus diisi!',
                'tanggal_pengajuan.date' => 'Tanggal pengajuan harus berupa tanggal!',
                'skala_kegiatan.required' => 'Skala kegiatan harus diisi!',
                'skala_kegiatan.in' => 'Skala kegiatan tidak valid!',
                'kebutuhan_dana.required' => 'Kebutuhan dana harus diisi!',
                'kebutuhan_dana.numeric' => 'Kebutuhan dana harus berupa angka!',
                'nomor_rekening.required' => 'Nomor rekening harus diisi!',
                'nomor_rekening.max' => 'Nomor rekening terlalu panjang!',
                'nama_rekening.required' => 'Nama rekening harus diisi!',
                'nama_rekening.max' => 'Nama rekening terlalu panjang!',
                'nama_bank.required' => 'Nama bank harus diisi!',
                'nama_bank.max' => 'Nama bank terlalu panjang!',
                'link_drive.required' => 'Link drive harus diisi!',
                'link_drive.url' => 'Link drive harus berupa URL yang valid!',
            ]
        );

        $proposal = Proposal::findOrFail($id);
        // Update data proposal
        $proposal->update([
            'organisasi_id' => $request->input('organisasi_id'),
            'nama_kegiatan' => $request->input('nama_kegiatan'),
            'deskripsi_kegiatan' => $request->input('deskripsi_kegiatan'),
            'tanggal_pelaksanaan' => $request->input('tanggal_pelaksanaan'),
            'tanggal_pengajuan' => $request->input('tanggal_pengajuan'),
            'skala_kegiatan' => $request->input('skala_kegiatan'),
            'kebutuhan_dana' => $request->input('kebutuhan_dana'),
            'nomor_rekening' => $request->input('nomor_rekening'),
            'nama_rekening' => $request->input('nama_rekening'),
            'nama_bank' => $request->input('nama_bank'),
            'link_drive' => $request->input('link_drive'),
            'status_pengajuan' => 'periksa', // Default status pengajuan
        ]);

        return redirect()->route('admin.proposal.index')->with('success', 'Proposal berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->delete();

        return redirect()->route('admin.proposal.index')->with('success', 'Proposal berhasil dihapus!');
    }
}