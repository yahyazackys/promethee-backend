<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\CalonPelaksana;
use App\Models\Pelaksana;
use App\Models\Portofolio;
use App\Models\Proyek;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userEmail = auth()->user()->email;

        // Dapatkan ID pelaksana berdasarkan email dari CalonPelaksana
        $pelaksanaIds = Pelaksana::whereHas('calonPelaksana', function ($query) use ($userEmail) {
            $query->where('email', $userEmail);
        })->pluck('id');

        $data1 = Pelaksana::with(['calonPelaksana', 'proyek'])
            ->orderBy('created_at', 'desc')
            ->first(); // Mengambil hanya satu entri terbaru


        $totalProyek = Proyek::count();
        $totalCalonPelaksana = CalonPelaksana::count();
        $totalPortofolio = Portofolio::count();


        return view('home', compact('totalProyek', 'totalCalonPelaksana', 'totalPortofolio', 'data1'));
    }
}
