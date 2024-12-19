<?php

namespace App\Http\Controllers;

use App\Models\Subkriteria;

use App\Models\Kriterias;
use Illuminate\Http\Request;

class SubkriteriaController extends Controller
{
    // Menampilkan daftar subkriteria
    public function index()
    {
        $subkriteria = Subkriteria::with('kriteria')->get(); // Mengambil data subkriteria dengan kriteria
        return view('subkriteria.index', compact('subkriteria'));
    }

    // Menampilkan form untuk menambah subkriteria
    public function create()
    {
        $kriteria = Kriterias::all(); // Mengambil semua data kriteria
        return view('subkriteria.create', compact('kriteria'));
    }

    // Menyimpan subkriteria baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric',
        ]);

        Subkriteria::create($validatedData);
        return redirect()->route('subkriteria.index')->with('success', 'Subkriteria berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit subkriteria
    public function edit($id)
    {
        $subkriteria = Subkriteria::findOrFail($id);
        $kriteria = Kriterias::all(); // Mengambil semua data kriteria
        return view('subkriteria.edit', compact('subkriteria', 'kriteria'));
    }

    // Memperbarui subkriteria yang sudah ada
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric',
        ]);

        $subkriteria = Subkriteria::findOrFail($id);
        $subkriteria->update($validatedData);

        return redirect()->route('subkriteria.index')->with('success', 'Subkriteria berhasil diperbarui!');
    }

    public function delete($id)
    {
        // query/perintah hapus data berdasarkan id
        Subkriteria::find($id)->delete();

        // kembalikan ke halaman users
        return redirect()->route('subkriteria.index')->with('success', 'Data kriteria Berhasil Dihapus!');
    }
}
