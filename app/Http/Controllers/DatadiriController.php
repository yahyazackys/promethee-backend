<?php

namespace App\Http\Controllers;

use App\Models\CalonPelaksana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DataDiriController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dataDiri = CalonPelaksana::where('email', $user->email)->firstOrFail();
        return view('datadiri.index', compact('dataDiri'));
    }

    public function create()
    {
        return view('datadiri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'npwp' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'ijazah' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'sertifikat' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        ]);

        $dataDiri = new CalonPelaksana([
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'email' => $request->email,
        ]);

        if ($request->hasFile('npwp')) {
            $dataDiri->npwp = $request->file('npwp')->store('uploads/npwp', 'public');
        }

        if ($request->hasFile('ijazah')) {
            $dataDiri->ijazah = $request->file('ijazah')->store('uploads/ijazah', 'public');
        }

        if ($request->hasFile('sertifikat')) {
            $dataDiri->sertifikat = $request->file('sertifikat')->store('uploads/sertifikat', 'public');
        }

        $dataDiri->save();

        return redirect()->route('datadiri.create')->with('success', 'Data diri berhasil disimpan.');
    }

    public function show($id)
    {
        $dataDiri = CalonPelaksana::findOrFail($id);
        return view('datadiri.show', compact('dataDiri'));
    }

    public function edit()
    {
        $user = Auth::user();
        $dataDiri = CalonPelaksana::where('email', $user->email)->firstOrFail();
        return view('datadiri.edit', compact('dataDiri'));
    }

    public function update(Request $request, $id)
    {
        // Validasi permintaan
        $request->validate([
            'nama' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'npwp' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'ijazah' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'sertifikat' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        ]);

        // Temukan record berdasarkan ID
        $dataDiri = CalonPelaksana::findOrFail($id);

        // Update hanya kolom yang ada di request
        $dataDiri->update($request->only([
            'nama',
            'tempat_lahir',
            'tanggal_lahir',
            'alamat',
            'email'
        ]));

        // Tangani file uploads
        if ($request->hasFile('npwp')) {
            // Hapus file lama jika ada
            if ($dataDiri->npwp) {
                Storage::disk('public')->delete($dataDiri->npwp);
            }
            $dataDiri->npwp = $request->file('npwp')->store('uploads/npwp', 'public');
        }

        if ($request->hasFile('ijazah')) {
            // Hapus file lama jika ada
            if ($dataDiri->ijazah) {
                Storage::disk('public')->delete($dataDiri->ijazah);
            }
            $dataDiri->ijazah = $request->file('ijazah')->store('uploads/ijazah', 'public');
        }

        if ($request->hasFile('sertifikat')) {
            // Hapus file lama jika ada
            if ($dataDiri->sertifikat) {
                Storage::disk('public')->delete($dataDiri->sertifikat);
            }
            $dataDiri->sertifikat = $request->file('sertifikat')->store('uploads/sertifikat', 'public');
        }

        // Simpan perubahan
        $dataDiri->save();

        // Redirect dengan pesan sukses
        return redirect()->route('datadiri.index')->with('success', 'Data Diri berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $dataDiri = CalonPelaksana::findOrFail($id);
        $dataDiri->delete();

        return redirect()->route('datadiri.index')->with('success', 'Data diri berhasil dihapus.');
    }
}
