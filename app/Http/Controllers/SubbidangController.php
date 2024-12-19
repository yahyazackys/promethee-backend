<?php

namespace App\Http\Controllers;

use App\Models\CalonPelaksana;
use App\Models\Pelaksana;
use App\Models\Penilaian;
use App\Models\Proyek;
use App\Models\Subbidang;
use Exception;
use Illuminate\Http\Request;

class SubbidangController extends Controller
{
    public function index()
    {
        // Mengambil semua data penilaian beserta relasi calon pelaksana
        // $datas = Pelaksana::get();
        $datas = Subbidang::get();

        return view('subbidang.index', compact('datas'));
    }

    public function create()
    {
        $data = Subbidang::all();

        return view('subbidang.create', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bidang' => 'required|string|max:255',
        ]);

        Subbidang::create([
            'nama_bidang' => $request->nama_bidang,
        ]);

        return redirect()->route('subbidang.index')->with('success', 'Data Pelaksana Proyek created successfully');
    }

    public function delete($id)
    {
        // query/perintah hapus data berdasarkan id
        Subbidang::find($id)->delete();

        // kembalikan ke halaman users
        return redirect()->route('subbidang.index')->with('success', 'Data kriteria Berhasil Dihapus!');
    }
}
