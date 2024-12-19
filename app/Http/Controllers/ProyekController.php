<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\Pelaksana;
use App\Models\Portofolio;
use App\Models\Proyek;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    public function index()
    {
        $userEmail = auth()->user()->email;

        // Dapatkan ID pelaksana berdasarkan email dari CalonPelaksana
        $pelaksanaId = Pelaksana::whereHas('calonPelaksana', function ($query) use ($userEmail) {
            $query->where('email', $userEmail);
        })->pluck('id');

        // Dapatkan data anggaran berdasarkan pelaksana_id yang ditemukan
        $data1 = Anggaran::whereIn('pelaksana_id', $pelaksanaId)->with('pelaksana')->get();
        $datas = Proyek::get();
        return view('proyek.index', compact('datas', 'data1'));
    }

    public function create()
    {
        return view('proyek.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'nullable|string|max:255',
            'progress' => 'nullable|string|max:255',
            'bukti1' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'bukti2' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'bukti3' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'bukti4' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'laporan_lapangan_bersama' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        ]);

        $data = new Proyek([
            'nama_proyek' => $request->nama_proyek,
            'progress' => $request->progress,
        ]);

        if ($request->hasFile('bukti1')) {
            $data->bukti1 = $request->file('bukti1')->store('uploads/bukti1', 'public');
        }

        if ($request->hasFile('bukti2')) {
            $data->bukti2 = $request->file('bukti2')->store('uploads/bukti2', 'public');
        }

        if ($request->hasFile('bukti3')) {
            $data->bukti3 = $request->file('bukti3')->store('uploads/bukti3', 'public');
        }

        if ($request->hasFile('bukti4')) {
            $data->bukti4 = $request->file('bukti4')->store('uploads/bukti4', 'public');
        }

        if ($request->hasFile('laporan_lapangan_bersama')) {
            $data->laporan_lapangan_bersama = $request->file('laporan_lapangan_bersama')->store('uploads/laporan_lapangan_bersama', 'public');
        }

        $data->save();

        return redirect()->route('proyek.index')->with('success', 'Data Proyek berhasil disimpan.');
    }

    public function edit($id)
    {
        $data = Proyek::find($id);
        return view('proyek.edit', compact('data'));
    }

    public function update(Request $request, $id)
{
    // Validasi request
    $request->validate([
        'nama_proyek' => 'nullable|string|max:255',
        'progress' => 'nullable|string|max:255',
        'bukti1' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        'bukti2' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        'bukti3' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        'bukti4' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        'laporan_lapangan_bersama' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
    ]);

    // Temukan data proyek berdasarkan ID
    $data = Proyek::find($id);
    $data->nama_proyek = $request->nama_proyek;
    $data->progress = $request->progress;

    // Simpan file bukti jika ada
    if ($request->hasFile('bukti1')) {
        $data->bukti1 = $request->file('bukti1')->store('uploads/bukti1', 'public');
    }

    if ($request->hasFile('bukti2')) {
        $data->bukti2 = $request->file('bukti2')->store('uploads/bukti2', 'public');
    }

    if ($request->hasFile('bukti3')) {
        $data->bukti3 = $request->file('bukti3')->store('uploads/bukti3', 'public');
    }

    if ($request->hasFile('bukti4')) {
        $data->bukti4 = $request->file('bukti4')->store('uploads/bukti4', 'public');
    }

    if ($request->hasFile('laporan_lapangan_bersama')) {
        $data->laporan_lapangan_bersama = $request->file('laporan_lapangan_bersama')->store('uploads/laporan_lapangan_bersama', 'public');
    }

    // Simpan perubahan ke database
    $data->save();

    // Jika progress diisi, update atau tambahkan data di tabel Portofolio
    if ($request->filled('progress')) {
        // Temukan pelaksana berdasarkan proyek_id
        $pelaksana = Pelaksana::where('proyek_id', $data->id)->first();

        if ($pelaksana) {
            // Temukan data di Portofolio berdasarkan pelaksana_id
            $portofolio = Portofolio::where('pelaksana_id', $pelaksana->id)->first();

            // Hitung selisih tanggal jika bukti4 di-upload
            if ($request->hasFile('bukti4')) {
                $tanggal_bukti4 = now(); // Tanggal saat ini atau tanggal upload bukti4 jika diambil dari file
                $tanggal_kontrak = new \Carbon\Carbon($pelaksana->tanggal_kontrak);
                $tanggal_selesai_kontrak = new \Carbon\Carbon($pelaksana->tanggal_selesai_kontrak);
                
                // Hitung selisih hari antara tanggal kontrak dan tanggal upload bukti4
                $selisih_tanggal = $tanggal_selesai_kontrak->diffInDays($tanggal_bukti4);
            } else {
                $selisih_tanggal = null; // Jika bukti4 tidak di-upload, tidak perlu menghitung selisih tanggal
            }

            if ($portofolio) {
                // Update jika data sudah ada
                $portofolio->k2 = $selisih_tanggal; // Perbarui k2 dengan selisih tanggal
                $portofolio->k3 = $request->progress; // Perbarui k3 dengan progress
                $portofolio->save();
            } else {
                // Tambah jika data belum ada
                Portofolio::create([
                    'pelaksana_id' => $pelaksana->id,
                    'k2' => $selisih_tanggal, // Tambahkan selisih tanggal ke kolom k2
                    'k1' => null, // Atur nilai default atau sesuai kebutuhan
                    'k3' => $request->progress, // Tambahkan progress ke kolom k3
                    'k4' => '1', // Atur nilai default atau sesuai kebutuhan
                ]);
            }
        } else {
            // Tangani kasus jika pelaksana tidak ditemukan
            return redirect()->route('proyek.index')->with('error', 'Pelaksana tidak ditemukan untuk proyek ini.');
        }
    }

    // Redirect dengan pesan sukses
    return redirect()->route('proyek.index')->with('success', 'Data Proyek berhasil diperbarui.');
}

    

    public function destroy($id)
    {
        $data = Proyek::find($id);
        $data->delete();

        return redirect()->route('proyek.index')->with('success', 'Data Proyek berhasil dihapus.');
    }
}
