<?php

namespace App\Http\Controllers;

use App\Models\CalonPelaksana;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = CalonPelaksana::where('email', $user->email)->firstOrFail();
        return view('anggaran.index', compact('data'));
    }

    public function create()
    {
        return view('proyek.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'nullable|string|max:255',
            'bukti1' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'bukti2' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'bukti3' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'bukti4' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        ]);

        $data = new Proyek([
            'nama_proyek' => $request->nama_proyek,
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
        $request->validate([
            'nama_proyek' => 'nullable|string|max:255',
            'bukti1' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'bukti2' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'bukti3' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'bukti4' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        ]);

        $data = Proyek::find($id);
        $data->nama_proyek = $request->nama_proyek;

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

        $data->save();

        return redirect()->route('proyek.index')->with('success', 'Data Proyek berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = Proyek::find($id);
        $data->delete();

        return redirect()->route('proyek.index')->with('success', 'Data Proyek berhasil dihapus.');
    }
}
