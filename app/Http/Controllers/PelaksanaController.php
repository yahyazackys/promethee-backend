<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\CalonPelaksana;
use App\Models\Pelaksana;
use App\Models\Penilaian;
use App\Models\Proyek;
use App\Models\Subbidang;
use Illuminate\Http\Request;

class PelaksanaController extends Controller
{
    public function index()
    {
        $datas = Pelaksana::with('subbidang', 'calonpelaksana', 'proyek')->get();
        return view('pelaksana.index', compact('datas'));
    }

    public function create()
    {
        $subbidangs = Subbidang::all();
        $proyeks = Proyek::all();
        $calonpelaksanas = CalonPelaksana::all();
        return view('pelaksana.create', compact('subbidangs', 'proyeks', 'calonpelaksanas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'calon_pelaksana_id' => 'required|exists:calon_pelaksanas,id',
            'sub_bidang_id' => 'required|exists:sub_bidangs,id',
            'proyek_id' => 'required|exists:proyeks,id',
            'no_kontrak' => 'required|string|max:255',
            'nilai_kontrak' => 'required|numeric',
            'tanggal_kontrak' => 'required|date',
            'tanggal_selesai_kontrak' => 'required|date',
        ]);

        // Buat entri baru di tabel pelaksanas
        $pelaksana = Pelaksana::create([
            'calon_pelaksana_id' => $request->calon_pelaksana_id,
            'sub_bidang_id' => $request->sub_bidang_id,
            'proyek_id' => $request->proyek_id,
            'no_kontrak' => $request->no_kontrak,
            'nilai_kontrak' => $request->nilai_kontrak,
            'tanggal_kontrak' => $request->tanggal_kontrak,
            'tanggal_selesai_kontrak' => $request->tanggal_selesai_kontrak,
        ]);

        Anggaran::create([
            'pelaksana_id' => $pelaksana->id,
            'total_anggaran' => $pelaksana->nilai_kontrak,
        ]);

        return redirect()->route('pelaksana.index')->with('success', 'Data Pelaksana Proyek created successfully');
    }


    public function edit($id)
    {
        $pelaksana = Pelaksana::findOrFail($id);
        $subbidangs = Subbidang::all();
        $proyeks = Proyek::all();
        $calonpelaksanas = CalonPelaksana::all();
        return view('pelaksana.edit', compact('pelaksana', 'subbidangs', 'proyeks', 'calonpelaksanas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'calon_pelaksana_id' => 'required|exists:calon_pelaksanas,id',
            'sub_bidang_id' => 'required|exists:sub_bidangs,id',
            'proyek_id' => 'required|exists:proyeks,id',
            'no_kontrak' => 'required|string|max:255',
            'nilai_kontrak' => 'required|numeric',
            'tanggal_kontrak' => 'required|date',
            'tanggal_selesai_kontrak' => 'required|date',
        ]);

        $pelaksana = Pelaksana::findOrFail($id);
        $pelaksana->update($request->all());

        return redirect()->route('pelaksana.index')->with('success', 'Data Pelaksana Proyek updated successfully');
    }

    public function delete($id)
    {
        Pelaksana::findOrFail($id)->delete();
        return redirect()->route('pelaksana.index')->with('success', 'Data kriteria Berhasil Dihapus!');
    }
}
