<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProsesSeleksiController extends Controller
{
    protected $pemohon;
    protected $kriteria;

    public function prosesSeleksi(Request $request)
    {
         // Tampilkan halaman default jika tidak ada input 'cari' atau 'simpan'
         if (!$request->has('cari') && !$request->has('simpan')) {
            return view('proses-seleksi.index');
        }
        if ($request->has('simpan')) {
            // Cek jika data sudah ada
            $cek = DB::table('hasils')
                ->where('dari_tgl', '>=', $request->input('dari1'))
                ->where('sampai_tgl', '<=', $request->input('sampai1'))
                ->count();

            if ($cek > 0) {
                return redirect()->route('proses-seleksi')->with('message', 'Data sudah ada!');
            }

            $pelapor = DB::table('pelaksanas')
            ->join('penilaians', 'penilaians.pelaksana_id', '=', 'pelaksanas.id')
            ->join('calon_pelaksanas', 'calon_pelaksanas.id', '=', 'pelaksanas.calon_pelaksana_id')
            ->whereBetween('penilaians.tgl', [$request->input('dari1'), $request->input('sampai1')])
            ->select('pelaksanas.id', 'calon_pelaksanas.nama', DB::raw('COUNT(penilaians.id) as count_penilaians'))
            ->groupBy('pelaksanas.id', 'calon_pelaksanas.nama')
            ->get();
        

            foreach ($pelapor as $datapelapor) {
                DB::table('hasils')->insert([
                    'pelaksana_id' => $datapelapor->id, 
                    'lev' => $request->input('lev_' . $datapelapor->id),
                    'ent' => $request->input('ent_' . $datapelapor->id),
                    'net' => $request->input('net_' . $datapelapor->id),
                    'dari_tgl' => $request->input('dari1'),
                    'sampai_tgl' => $request->input('sampai1'),
                    'status' => 'proses',
                ]);
            }            

            return redirect()->route('proses-seleksi')->with('message', 'Data berhasil disimpan!');
        }

        if ($request->has('cari')) {
            // Cek jika ada penilaian pada rentang tanggal
            $cek = DB::table('penilaians')
                ->where('tgl', '>=', $request->input('dari_tgl'))
                ->where('tgl', '<=', $request->input('sampai_tgl'))
                ->count();
    
            if ($cek <= 1) {
                return redirect()->route('proses-seleksi.index')->with('message', 'Maaf, alternatif harus lebih dari 1!');
            }
    
            $this->loadPemohon();
            $this->loadKriteria();
    
            $data_calon_pelaksanas = $this->getAltName($request->input('dari_tgl'), $request->input('sampai_tgl'));
            $data_kriteria = $this->getKriteria();
            $nil = $this->getNilai($request->input('dari_tgl'), $request->input('sampai_tgl'));
    
        //    dd($data_calon_pelaksanas);

            $nilai_perbandingan = [];

            foreach ($data_kriteria as $kriteria) {
                foreach ($data_calon_pelaksanas as $calon1) {
                    foreach ($data_calon_pelaksanas as $calon2) {
                        if ($calon1->id != $calon2->id) {
                            $nilai1 = $nil[$calon1->id][$kriteria->id] ?? 0;
                            $nilai2 = $nil[$calon2->id][$kriteria->id] ?? 0;
                            $nilai_perbandingan[$kriteria->id][$calon1->id][$calon2->id] = $nilai1 - $nilai2;
                            $nilai_perbandingan[$kriteria->id][$calon2->id][$calon1->id] = $nilai2 - $nilai1;
                        }
                    }
                }
            }

            $nilai_preferensi = [];
            foreach ($data_kriteria as $kriteria) {
                foreach ($data_calon_pelaksanas as $calon1) {
                    foreach ($data_calon_pelaksanas as $calon2) {
                        if ($calon1->id != $calon2->id) {
                            $nilai_perbandingan_value = $nilai_perbandingan[$kriteria->id][$calon1->id][$calon2->id] ?? 0;
                            $nilai_preferensi[$kriteria->id][$calon1->id][$calon2->id] = $nilai_perbandingan_value > 0 ? 1 : 0;
                        }
                    }
                }
            }

            $jarak_kriteria = [];
            $h_d = [];
            $h_ds = [];
            $ranking = [];
            $hasil = [];

            foreach ($data_calon_pelaksanas as $calon) {
                $key = $calon->id;
                $hasil[$key] = [
                    'leaving' => 0,
                    'entering' => 0,
                    'net_flow' => 0,
                ];
            }

            foreach ($data_kriteria as $key_kriteria => $value_kriteria) {
                $y = 1;
                foreach ($data_calon_pelaksanas as $key_calon_y => $value_calon_y) {
                    $z = 1;
                    $tmp_bobot_y = $nil[$value_calon_y->id][$value_kriteria->id] ?? 0;
                    $h_d[$key_kriteria][$value_calon_y->id] = [0];

                    foreach ($data_calon_pelaksanas as $key_calon_x => $value_calon_x) {
                        $tmp_bobot_x = $nil[$value_calon_x->id][$value_kriteria->id] ?? 0;

                        if ($y != $z) {
                            $jka = $tmp_bobot_y - $tmp_bobot_x;
                            $jarak_kriteria[$key_kriteria][$value_calon_y->id][] = $jka;
                            $nilai_pref = $this->nilaiPreferensi($jka);
                            $h_d[$key_kriteria][$value_calon_y->id][] = $nilai_pref;
                        } else {
                            $nilai_pref = 0;
                        }
                        $h_ds[$key_kriteria][$value_calon_y->id][] = $nilai_pref;
                        $z++;
                    }
                    $y++;
                }
            }

            for ($i = 0; $i < count($data_calon_pelaksanas); $i++) {
                $hasiljumlah = [];
                for ($j = 0; $j < count($data_calon_pelaksanas); $j++) {
                    $tmp_sum = 0;
                    $tmp_sum1 = 0;
                    foreach ($data_kriteria as $key => $value) {
                        if ($j != $i) {
                            $tmp_sum += $h_d[$key][$data_calon_pelaksanas[$i]->id][$j];
                        }
                        $tmp_sum1 += $h_ds[$key][$data_calon_pelaksanas[$i]->id][$j];
                    }
                    $ranking[$data_calon_pelaksanas[$i]->id][$j] = ($i != $j) ? (1 / count($data_kriteria)) * $tmp_sum : 0;
                    $hasiljumlah[$i][$j] = ($i != $j) ? (1 / count($data_kriteria)) * $tmp_sum : 0;
                    $rankings[$data_calon_pelaksanas[$i]->id][$j] = (1 / count($data_kriteria)) * $tmp_sum;
                    $rankings1[$data_calon_pelaksanas[$i]->id][$j] = (1 / count($data_kriteria)) * $tmp_sum1;
                }
                $hasil[$data_calon_pelaksanas[$i]->id]['leaving'] = (1 / (count($data_calon_pelaksanas) - 1)) * array_sum($hasiljumlah[$i]);
            }

            for ($j = 0; $j < count($data_calon_pelaksanas); $j++) {
                $tmp_entering = 0;
                for ($i = 0; $i < count($data_calon_pelaksanas); $i++) {
                    $tmp_entering += $rankings1[$data_calon_pelaksanas[$i]->id][$j];
                }
                $hasil[$data_calon_pelaksanas[$j]->id]['entering'] = $tmp_entering / (count($data_calon_pelaksanas) - 1);
                $hasil[$data_calon_pelaksanas[$j]->id]['net_flow'] = $hasil[$data_calon_pelaksanas[$j]->id]['leaving'] - $hasil[$data_calon_pelaksanas[$j]->id]['entering'];
            }

            return view('proses-seleksi.index', compact('data_calon_pelaksanas', 'data_kriteria', 'nil', 'rankings1', 'hasil', 'nilai_perbandingan', 'nilai_preferensi'));
        }
    }

    public function nilaiPreferensi($value)
    {
        return $value > 0 ? 1 : 0;
    }

    protected function getAltName($dari, $sampai)
    {
        return DB::table('pelaksanas')
            ->join('penilaians', 'penilaians.pelaksana_id', '=', 'pelaksanas.id')
            ->join('calon_pelaksanas', 'calon_pelaksanas.id', '=', 'pelaksanas.calon_pelaksana_id') // Join dengan tabel calon_pelaksanas
            ->whereBetween('penilaians.tgl', [$dari, $sampai])
            ->select('pelaksanas.id', 'calon_pelaksanas.nama') // Ambil nama dari tabel calon_pelaksanas
            ->distinct()
            ->get();
    }

    private function getNilai($dari_tgl, $sampai_tgl)
    {
        $alternatifkriteria = [];
        
        $pelaksanas = DB::table('pelaksanas')
            ->join('penilaians', 'penilaians.pelaksana_id', '=', 'pelaksanas.id')
            ->join('sub_kriterias', 'penilaians.sub_kriteria_id', '=', 'sub_kriterias.id')
            ->whereBetween('penilaians.tgl', [$dari_tgl, $sampai_tgl])
            ->select('pelaksanas.id', 'penilaians.nilai', 'sub_kriterias.kriteria_id as id_kriteria')
            ->get();
        
        // Debugging output
        // dd($pelaksanas);
    
        foreach ($pelaksanas as $data) {
            $alternatifkriteria[$data->id][$data->id_kriteria] = $data->nilai;
        }
        // dd($alternatifkriteria);
        return $alternatifkriteria;
    }

    public function getKriteria()
    {
        return DB::table('kriterias')->get();
    }

    private function loadPemohon()
    {
        $this->pemohon = DB::table('calon_pelaksanas')->get();
    }

    private function loadKriteria()
    {
        $this->kriteria = DB::table('kriterias')->get();
    }
}
