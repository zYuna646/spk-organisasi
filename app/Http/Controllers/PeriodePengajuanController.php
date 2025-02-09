<?php

namespace App\Http\Controllers;

use App\Models\PeriodePengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PeriodePengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.master-data.periode_pengajuan.index', [
            'title' => 'Periode Pengajuan',
            'subtitle' => '',
            'active' => 'periode_pengajuan',
            'datas' => PeriodePengajuan::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.master-data.periode_pengajuan.create', [
            'title' => 'Periode Pengajuan',
            'subtitle' => 'Add Periode Pengajuan',
            'active' => 'periode_pengajuan',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, 
            [
                'name' => 'required|unique:periode_pengajuans,name',
                'periode_mulai' => 'required|date', // Validasi periode_mulai sebagai tanggal
            ],
            [
                'name.required' => 'Name is required!',
                'name.unique' => 'This name is already exists!',
                'periode_mulai.required' => 'Periode mulai is required!',
                'periode_mulai.date' => 'Periode mulai must be a valid date!',
            ]
        );

        PeriodePengajuan::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'periode_mulai' => $request->periode_mulai, // Menyimpan periode_mulai
        ]);

        return redirect()->route('admin.periode_pengajuan.index')->with('success', 'Periode Pengajuan has been added!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin.master-data.periode_pengajuan.edit', [
            'title' => 'Periode Pengajuan',
            'subtitle' => 'Edit Periode Pengajuan',
            'active' => 'periode_pengajuan',
            'data' => PeriodePengajuan::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, 
            [
                'name' => 'required|unique:periode_pengajuans,name,' . $id,
                'periode_mulai' => 'required|date', // Validasi periode_mulai sebagai tanggal
            ],
            [
                'name.required' => 'Name is required!',
                'name.unique' => 'This name is already exists!',
                'periode_mulai.required' => 'Periode mulai is required!',
                'periode_mulai.date' => 'Periode mulai must be a valid date!',
            ]
        );

        $periodePengajuan = PeriodePengajuan::findOrFail($id);

        $periodePengajuan->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'periode_mulai' => $request->periode_mulai, // Menyimpan periode_mulai
        ]);

        return redirect()->route('admin.periode_pengajuan.index')->with('success', 'Periode Pengajuan has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $periodePengajuan = PeriodePengajuan::findOrFail($id);
        $periodePengajuan->delete();

        return redirect()->route('admin.periode_pengajuan.index')->with('success', 'Periode Pengajuan has been deleted!');
    }
}
