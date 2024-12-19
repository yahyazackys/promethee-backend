<?php

namespace App\Http\Controllers;

use App\Models\Kriterias;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriterias::all();
        return view('kriteria.index', compact('kriteria'));
    }

    public function create()
    {
        // Tidak perlu mengambil data kriteria di sini
        return view('kriteria.create');
    }

    // Menyimpan data kriteria ke dalam database
    public function store(Request $request)
    {
        // Validasi data dari request
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Menyimpan data baru ke dalam tabel kriteria
        Kriterias::create($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('kriteria')->with('success', 'Data kriteria berhasil ditambahkan!');
    }

    // Menampilkan halaman form untuk mengedit kriteria
    public function edit($id)
    {
        // Mengambil data kriteria berdasarkan ID
        $kriteria = Kriterias::findOrFail($id);

        // Menampilkan halaman form edit dengan data kriteria
        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $nama = $request->nama;
        // Validasi data dari request
        $validatedData = $request->validate([
            // 'id' => 'required|exists:kriteria,id',
            'nama' => 'required|string|max:255',
        ]);

        // Mengambil data kriteria berdasarkan ID dan memperbarui data
        $kriteria = Kriterias::find($id);
        $kriteria->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('kriteria')->with('success', 'Data kriteria berhasil diperbarui!');
    }

    public function delete($id)
    {
        // query/perintah hapus data berdasarkan id
        Kriterias::find($id)->delete();

        // kembalikan ke halaman users
        return redirect()->route('kriteria')->with('success', 'Data kriteria Berhasil Dihapus!');
    }
}
