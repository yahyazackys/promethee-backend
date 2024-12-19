<?php

namespace App\Http\Controllers;

use App\Models\CalonPelaksana;
use App\Models\Pelaksana;
use App\Models\Penilaian;
use App\Models\Portofolio;
use App\Models\Subkriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortofolioController extends Controller
{
    public function storePenilaian(Request $request)
    {
        $request->validate([
            'pelaksana_id' => 'required|exists:pelaksanas,id',
            'k1' => 'required|numeric',
            'k2' => 'required|numeric',
            'k3' => 'required|numeric',
            'k4' => 'required|numeric',
        ]);

        $currentDate = now();
        $inputPelaksanaId = $request->input('pelaksana_id');

        // Retrieve the calon_pelaksana_id from the pelaksanas table
        $calonPelaksanaId = DB::table('pelaksanas')
            ->where('id', $inputPelaksanaId)
            ->value('calon_pelaksana_id');

        if (!$calonPelaksanaId) {
            return redirect()->back()->withErrors('Pelaksana ID not found in the Pelaksanas table.');
        }

        $subKriterias = [
            'k1' => $this->getSubKriteriaId(1, $request->input('k1')),
            'k2' => $this->getSubKriteriaId(2, $request->input('k2')),
            'k3' => $this->getSubKriteriaId(3, $request->input('k3')),
            'k4' => $this->getSubKriteriaId(4, $request->input('k4')),
        ];

        foreach ($subKriterias as $key => $data) {
            // Check if there's an existing record for this pelaksana_id and sub_kriteria_id
            $existingPenilaian = Penilaian::whereHas('pelaksana', function ($query) use ($calonPelaksanaId) {
                $query->where('calon_pelaksana_id', $calonPelaksanaId);
            })
                ->where('sub_kriteria_id', $data['sub_kriteria_id'])
                ->first();

            if ($existingPenilaian) {
                // If an existing record is found, sum the new nilai with the existing one
                $existingPenilaian->update([
                    'nilai' => $existingPenilaian->nilai + $data['nilai'],
                    'tgl' => $currentDate,
                ]);
            } else {
                // If no existing record is found, create a new one
                Penilaian::create([
                    'pelaksana_id' => $inputPelaksanaId,
                    'sub_kriteria_id' => $data['sub_kriteria_id'],
                    'nilai' => $data['nilai'],
                    'tgl' => $currentDate,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data Penilaian created or updated successfully');
    }

    private function getSubKriteriaId($kriteriaId, $nilai)
    {
        $subKriterias = DB::table('sub_kriterias')->where('kriteria_id', $kriteriaId)->get();

        foreach ($subKriterias as $subKriteria) {
            $nama = $subKriteria->nama;

            if (strpos($nama, '>=') === 0 && $nilai >= (float)substr($nama, 2)) {
                return ['sub_kriteria_id' => $subKriteria->id, 'nilai' => $nilai];
            } elseif (strpos($nama, '<=') === 0 && $nilai <= (float)substr($nama, 2)) {
                return ['sub_kriteria_id' => $subKriteria->id, 'nilai' => $nilai];
            } elseif (strpos($nama, '-') !== false) {
                [$min, $max] = explode('-', $nama);
                if ($nilai >= (float)$min && $nilai <= (float)$max) {
                    return ['sub_kriteria_id' => $subKriteria->id, 'nilai' => $nilai];
                }
            } elseif ($nama == (string)$nilai) {
                return ['sub_kriteria_id' => $subKriteria->id, 'nilai' => $nilai];
            }
        }

        // If no sub_kriteria matches, return a default value or handle the error
        return ['sub_kriteria_id' => null, 'nilai' => $nilai];
    }

    public function index()
    {
        $userEmail = auth()->user()->email;

        // Dapatkan ID pelaksana berdasarkan email dari CalonPelaksana
        $pelaksanaId = Pelaksana::whereHas('calonPelaksana', function ($query) use ($userEmail) {
            $query->where('email', $userEmail);
        })->pluck('id');

        // Dapatkan data anggaran berdasarkan pelaksana_id yang ditemukan
        $datas = Portofolio::whereIn('pelaksana_id', $pelaksanaId)->with('pelaksana')->get();
        $data1 = Portofolio::with('pelaksana')->get();

        return view('portofolio.index', compact('datas', 'data1'));
    }

    public function create()
    {
        $pelaksanas = Pelaksana::with('calonpelaksana')->get();
        return view('portofolio.create', compact('pelaksanas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'k1' => 'required',
            'k2' => 'required',
            'k3' => 'required',
            'k4' => 'required',
        ]);

        $data = new Portofolio([
            'pelaksana_id' => $request->pelaksana_id,
            'k1' => $request->k1,
            'k2' => $request->k2,
            'k3' => $request->k3,
            'k4' => $request->k4,
        ]);

        $data->save();

        return redirect()->route('portofolio.index')->with('success', 'Data portofolio berhasil disimpan.');
    }

    public function edit($id)
    {
        $data = Portofolio::findOrFail($id);
        $pelaksanas = Pelaksana::with('calonpelaksana')->get();
        return view('portofolio.edit', compact('data', 'pelaksanas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'k1' => 'required',
            'k2' => 'required',
            'k3' => 'required',
            'k4' => 'required',
        ]);

        $data = Portofolio::find($id);
        $data->k1 = $request->k1;
        $data->k2 = $request->k2;
        $data->k3 = $request->k3;
        $data->k4 = $request->k4;

        $data->save();

        return redirect()->route('portofolio.index')->with('success', 'Data portofolio berhasil diperbarui.');
    }

    public function delete($id)
    {
        // query/perintah hapus data berdasarkan id
        Portofolio::find($id)->delete();

        // kembalikan ke halaman users
        return redirect()->route('portofolio.index')->with('success', 'Data portofolio Berhasil Dihapus!');
    }
}