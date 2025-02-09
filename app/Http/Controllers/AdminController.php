<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Category;
use App\Models\Information;
use App\Models\Kegiatan;
use App\Models\Laporan;
use App\Models\Proposal;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Carbon\Carbon;
class AdminController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::where('status_pengajuan', 'terima')
            ->where('status', '==', true)
            ->get()
            ->map(function ($item) {
                $item->jenis = 'kegiatan';
                return $item;
            });

        $proposal = Proposal::where('status_pengajuan', 'terima')
            ->where('status', '==', true)
            ->get()
            ->map(function ($item) {
                $item->jenis = 'proposal';
                return $item;
            });

        // Menggabungkan kegiatan dan proposal
        $data = $kegiatan->concat($proposal);

        // Mengumpulkan tanggal dan informasi kegiatan/proposal
        $events = $data->map(function ($item) {
            return [
                'title' => $item->nama_kegiatan,
                // Pastikan tanggal_pelaksanaan di-convert menjadi Carbon dan dipanggil toDateString()
                'start' => Carbon::parse($item->tanggal_pelaksanaan)->toDateString(),
                'skala_kegiatan' => $item->skala_kegiatan,
                'jenis' => $item->jenis,
                'organisasi' => $item->organisasi->user->name,
                'id' => $item->id,
            ];
        });


        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'subtitle' => '',
            'active' => 'dashboard',
            'datas' => $data,
            'events' => $events,
            'proposal' => Proposal::count(),
            'kegiatan' => Kegiatan::count(),
            'laporan' => Laporan::count(),
        ]);
    }


    public function rangking()
    {
        // Ambil semua kegiatan dan proposal dengan status pengajuan diterima
        $kegiatan = Kegiatan::where('status_pengajuan', 'terima')
            ->where('status', '!=', true)
            ->get()
            ->map(function ($item) {
                $item->jenis = 'kegiatan';
                return $item;
            });

        $proposal = Proposal::where('status_pengajuan', 'terima')
            ->where('status', '!=', true)
            ->get()
            ->map(function ($item) {
                $item->jenis = 'proposal';
                return $item;
            });

        // Menggabungkan kegiatan dan proposal dalam satu collection
        $data = $kegiatan->concat($proposal);

        // Proses perhitungan skor dengan bobot kriteria
        $ranking = $data->map(function ($item) {
            // Konversi tanggal menjadi objek Carbon
            $tanggal_pelaksanaan = Carbon::parse($item->tanggal_pelaksanaan);
            $tanggal_pengajuan = Carbon::parse($item->tanggal_pengajuan);

            // Menghitung selisih tanggal dalam hari
            $diff = $tanggal_pengajuan->diffInDays($tanggal_pelaksanaan);

            // Poin berdasarkan jarak waktu (30% bobot)
            if ($diff <= 3) {
                $jarak_poin = 10;
            } elseif ($diff <= 5) {
                $jarak_poin = 8;
            } elseif ($diff <= 7) {
                $jarak_poin = 6;
            } elseif ($diff <= 14) {
                $jarak_poin = 4;
            } elseif ($diff <= 30) {
                $jarak_poin = 2;
            } else {
                $jarak_poin = 0;
            }

            // Poin berdasarkan skala kegiatan (20% bobot)
            $skala_poin = match ($item->skala_kegiatan) {
                'nasional' => 9,
                'provinsi' => 7,
                'daerah' => 5,
                default => 0
            };

            // Poin berdasarkan relevansi (50% bobot)
            $relevansi_poin = match ($item->relevansi) {
                'sangat sesuai' => 8,
                'sesuai' => 6,
                'tidak sesuai' => 3,
                'sangat tidak sesuai' => 2,
                default => 0
            };

            // Menghitung total skor dengan bobot
            $total_poin = ($relevansi_poin * 0.5) + ($jarak_poin * 0.3) + ($skala_poin * 0.2);

            // Menyimpan total poin dalam item
            $item->total_poin = $total_poin;

            return $item;
        });

        // Mengurutkan berdasarkan total poin secara descending
        $ranking = $ranking->sortByDesc('total_poin')->values();
        // Menampilkan hasil rangking
        return view('admin.master-data.rangking.index', [
            'title' => 'Rangking',
            'subtitle' => '',
            'active' => 'rangking',
            'datas' => $ranking,
        ]);
    }


    public function terima($id)
    {
        $kegiatan = Kegiatan::find($id);
        $proposal = Proposal::find($id);
        if ($kegiatan) {
            $kegiatan->status = true;
            $kegiatan->save();
        }

        if ($proposal) {
            $proposal->status = true;
            $proposal->status = true;
        }

        return redirect()->route('admin.rangking.index')->with('sucess', 'Berhasil Menerima');
    }

    public function accountSetting()
    {
        return view('admin.settings.account-setting.index', [
            'title' => 'Account Setting',
            'subtitle' => '',
            'active' => 'account-setting',
        ]);
    }

    public function changePassword(Request $request, $id)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_new_password' => 'required|same:new_password',
        ], [
            'current_password.required' => 'Current Password is required',
            'new_password.required' => 'New Password is required',
            'new_password.min' => 'New Password must be at least 8 characters',
            'confirm_new_password.required' => 'Confirm New Password is required',
            'confirm_new_password.same' => 'Confirm New Password must be same with New Password',
        ]);

        $user = User::findOrFail($id);

        if (password_verify($request->current_password, $user->password)) {
            $user->update([
                'password' => bcrypt($request->new_password),
            ]);

            return redirect()->back()->with('success', 'Password has been changed');
        } else {
            return redirect()->back()->with('error', 'Current Password is wrong');
        }
    }

    public function changeInformation(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Information has been changed');
    }
}
