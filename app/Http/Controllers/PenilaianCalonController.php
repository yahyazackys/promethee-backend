<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Portofolio;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianCalonController extends Controller
{
    public function index()
    {
        // Mengambil semua data penilaian beserta relasi pelaksana dan calon pelaksana
        $datas = Portofolio::with('pelaksana.calonPelaksana', 'pelaksana.subBidang', 'pelaksana.proyek')->get();

        // Mengambil bobot dari sub_kriteria berdasarkan kriteria_id
        $subKriteria = SubKriteria::all()->groupBy('kriteria_id');

        return view('penilaian-calon.index', compact('datas', 'subKriteria'));
    }

    public function checkRecord(Request $request)
    {
        $pelaksana_id = $request->pelaksana_id;
        $existingRecord = Penilaian::where('pelaksana_id', $pelaksana_id)->first();

        return response()->json([
            'exists' => $existingRecord ? true : false,
            'existingRecord' => $existingRecord
        ]);
    }
}
