<?php

namespace App\Http\Controllers;

use App\Models\Hasil;

class HasilController extends Controller
{
    public function index()
    {
        $datas = Hasil::with('pelaksana')->orderBy('net', 'DESC')->get();

        return view('hasil-perangkingan.index', compact('datas'));
    }

    public function updateStatus($id)
    {
        $hasil = Hasil::findOrFail($id);
        if ($hasil->status == 'proses') {
            $hasil->status = 'diajukan';
        } elseif ($hasil->status == 'diajukan') {
            $hasil->status = 'diterima';
        }
        $hasil->save();

        return redirect()->back()->with('success', 'Status berhasil diubah.');
    }
}
