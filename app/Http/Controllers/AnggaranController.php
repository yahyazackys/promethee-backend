<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\CalonPelaksana;
use App\Models\Pelaksana;
use App\Models\Portofolio;
use App\Models\Proyek;
use Illuminate\Http\Request;

class AnggaranController extends Controller
{
    public function index()
    {
        $userEmail = auth()->user()->email;

        // Dapatkan ID pelaksana berdasarkan email dari CalonPelaksana
        $pelaksanaId = Pelaksana::whereHas('calonPelaksana', function ($query) use ($userEmail) {
            $query->where('email', $userEmail);
        })->pluck('id');

        // Dapatkan data anggaran berdasarkan pelaksana_id yang ditemukan
        $datas = Anggaran::whereIn('pelaksana_id', $pelaksanaId)->with('pelaksana')->get();
        $data1 = Anggaran::with('pelaksana')->get();

        return view('anggaran.index', compact('datas', 'data1'));
    }

    public function create()
    {
        $pelaksanas = Pelaksana::with('calonpelaksana', 'proyek')->get();
        return view('anggaran.create', compact('pelaksanas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelaksana_id' => 'required|exists:pelaksanas,id',
            'termin1_bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'termin2_bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'termin3_bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'termin4_bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        ]);

        $pelaksana = Pelaksana::findOrFail($request->pelaksana_id);

        $data = new Anggaran([
            'pelaksana_id' => $request->pelaksana_id,
            'total_anggaran' => $pelaksana->total_anggaran,
            'termin1' => $request->termin1,
            'termin2' => $request->termin2,
            'termin3' => $request->termin3,
            'termin4' => $request->termin4,
        ]);

        if ($request->hasFile('termin1_bukti')) {
            $data->termin1_bukti = $request->file('termin1_bukti')->store('uploads/termin1_bukti', 'public');
        }

        if ($request->hasFile('termin2_bukti')) {
            $data->termin2_bukti = $request->file('termin2_bukti')->store('uploads/termin2_bukti', 'public');
        }

        if ($request->hasFile('termin3_bukti')) {
            $data->termin3_bukti = $request->file('termin3_bukti')->store('uploads/termin3_bukti', 'public');
        }

        if ($request->hasFile('termin4_bukti')) {
            $data->termin4_bukti = $request->file('termin4_bukti')->store('uploads/termin4_bukti', 'public');
        }

        $data->save();

        return redirect()->route('anggaran.index')->with('success', 'Data Anggaran berhasil disimpan.');
    }

    public function edit($id)
    {
        $data = Anggaran::findOrFail($id);
        $pelaksanas = Pelaksana::with('calonpelaksana', 'proyek')->get();
        return view('anggaran.edit', compact('data', 'pelaksanas'));
    }

    public function update(Request $request, $id)
    {

        // dd($request->all());
        // Validasi input
        $request->validate([
            'termin1' => 'nullable|numeric|min:0',
            'termin2' => 'nullable|numeric|min:0',
            'termin3' => 'nullable|numeric|min:0',
            'termin4' => 'nullable|numeric|min:0',
            'termin1_bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'termin2_bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'termin3_bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'termin4_bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        ]);
    
        // Temukan data anggaran
        $data = Anggaran::findOrFail($id);
    
        // Update data anggaran
        // $data->pelaksana_id = $request->pelaksana_id;
        // $data->proyek_id = $request->proyek_id;
        $data->termin1 = $request->termin1;
        $data->termin2 = $request->termin2;
        $data->termin3 = $request->termin3;
        $data->termin4 = $request->termin4;
    
        // Hitung sisa anggaran
        $total_termin = ($request->termin1 ?? 0) + ($request->termin2 ?? 0) + ($request->termin3 ?? 0) + ($request->termin4 ?? 0);
        // dd($total_termin);
        $data->sisa_anggaran = $data->total_anggaran - $total_termin;
    
        // Hitung k1 sebagai persentase dari sisa anggaran
        $k1 = ($data->total_anggaran > 0) ? ($data->sisa_anggaran / $data->total_anggaran) * 100 : 0;
        // dd($k1);
    
        // Simpan bukti-bukti jika ada
        if ($request->hasFile('termin1_bukti')) {
            $data->termin1_bukti = $request->file('termin1_bukti')->store('uploads/termin1_bukti', 'public');
        }
    
        if ($request->hasFile('termin2_bukti')) {
            $data->termin2_bukti = $request->file('termin2_bukti')->store('uploads/termin2_bukti', 'public');
        }
    
        if ($request->hasFile('termin3_bukti')) {
            $data->termin3_bukti = $request->file('termin3_bukti')->store('uploads/termin3_bukti', 'public');
        }
    
        if ($request->hasFile('termin4_bukti')) {
            $data->termin4_bukti = $request->file('termin4_bukti')->store('uploads/termin4_bukti', 'public');
        }
    
        // Simpan perubahan data anggaran ke database
        $data->save();
    
        // Cek data request dan perhitungan


// Pastikan data yang sudah ada
$dataPortofolio = Portofolio::where('pelaksana_id', $request->pelaksana_id)->first();


        // Update atau buat data di tabel portofolio
        Portofolio::updateOrCreate(
            [
                'pelaksana_id' => $data->pelaksana_id,
            ],
            [
                'k1' => $k1, // Simpan nilai k1 ke kolom k2 di portofolio
                 'pelaksana_id' => $data->pelaksana_id,
            ]
        );
    
        // Redirect dengan pesan sukses
        return redirect()->route('anggaran.index')->with('success', 'Data Anggaran dan Portofolio berhasil diperbarui.');
    }
    


    public function destroy($id)
    {
        Anggaran::find($id)->delete();

        return redirect()->route('anggaran.index')->with('success', 'Data Anggaran Berhasil Dihapus!');
    }
}
