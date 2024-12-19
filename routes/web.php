<?php

use App\Http\Controllers\AnggaranController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DatadiriController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\PelaksanaController;
use App\Http\Controllers\PenilaianCalonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubbidangController;
use App\Http\Controllers\SubkriteriaController;
use App\Http\Controllers\ProsesSeleksiController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\PortofolioController;


Route::get('/', function () {
    return view('auth.login');
});



Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::post('/penilaian/store', [PortofolioController::class, 'storePenilaian'])->name('penilaian.store');
    // User
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/create', [UserController::class, 'create'])->name('user-create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user-store');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user-edit');
    Route::post('/user/update', [UserController::class, 'update'])->name('user-update');
    Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('user-delete');

    // Proyek
    Route::get('/proyek', [ProyekController::class, 'index'])->name('proyek.index');
    Route::get('/proyek/create', [ProyekController::class, 'create'])->name('proyek.create');
    Route::post('/proyek', [ProyekController::class, 'store'])->name('proyek.store');
    Route::get('/proyek/{id}/edit', [ProyekController::class, 'edit'])->name('proyek.edit');
    Route::put('/proyek/{id}', [ProyekController::class, 'update'])->name('proyek.update');
    Route::get('/proyek/delete/{id}', [ProyekController::class, 'destroy'])->name('proyek.delete');

    // Anggaran
    Route::get('/anggaran', [AnggaranController::class, 'index'])->name('anggaran.index');
    Route::get('/anggaran/create', [AnggaranController::class, 'create'])->name('anggaran.create');
    Route::post('/anggaran', [AnggaranController::class, 'store'])->name('anggaran.store');
    Route::get('/anggaran/{id}/edit', [AnggaranController::class, 'edit'])->name('anggaran.edit');
    Route::put('/anggaran/{id}', [AnggaranController::class, 'update'])->name('anggaran.update');
    Route::get('/anggaran/delete/{id}', [AnggaranController::class, 'destroy'])->name('anggaran.delete');
    Route::get('/get-proyeks-by-pelaksana', [AnggaranController::class, 'getProyeksByPelaksana'])->name('getProyeksByPelaksana');

    // Data Diri
    Route::get('/datadiri', [DatadiriController::class, 'index'])->name('datadiri.index');
    Route::get('/datadiri/create', [DatadiriController::class, 'create'])->name('datadiri.create');
    Route::post('/datadiri/store', [DatadiriController::class, 'store'])->name('datadiri.store');
    Route::get('/datadiri/edit/{id}', [DatadiriController::class, 'edit'])->name('datadiri.edit');
    Route::put('datadiri/update/{id}', [DatadiriController::class, 'update'])->name('datadiri.update');
    Route::get('/datadiri/delete/{id}', [DatadiriController::class, 'delete'])->name('datadiri.delete');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    // Data Kriteria
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria');
    Route::get('/kriteria/create', [KriteriaController::class, 'create'])->name('kriteria-create');
    Route::post('/kriteria/store', [KriteriaController::class, 'store'])->name('kriteria-store');
    Route::get('/kriteria/edit/{id}', [KriteriaController::class, 'edit'])->name('kriteria-edit');
    Route::post('/kriteria/update', [KriteriaController::class, 'update'])->name('kriteria-update');
    Route::get('/kriteria/delete/{id}', [KriteriaController::class, 'delete'])->name('kriteria-delete');

    // Data Sub Kriteria
    Route::get('/subkriteria', [SubkriteriaController::class, 'index'])->name('subkriteria.index');
    Route::get('/subkriteria/create', [SubkriteriaController::class, 'create'])->name('subkriteria.create');
    Route::post('/subkriteria', [SubkriteriaController::class, 'store'])->name('subkriteria.store');
    Route::get('/subkriteria/edit/{id}', [SubkriteriaController::class, 'edit'])->name('subkriteria.edit');
    Route::post('/subkriteria/update/{id}', [SubkriteriaController::class, 'update'])->name('subkriteria.update');
    Route::get('/subkriteria/delete/{id}', [SubkriteriaController::class, 'delete'])->name('subkriteria-delete');

    Route::get('/proses-seleksi', [ProsesSeleksiController::class, 'prosesSeleksi'])->name('proses-seleksi.index');
    Route::post('/proses-seleksi', [ProsesSeleksiController::class, 'prosesSeleksi'])->name('proses-seleksi');

    Route::get('/penilaian-calon', [PenilaianCalonController::class, 'index'])->name('penilaian-calon.index');

    Route::get('/hasil-perangkingan', [HasilController::class, 'index'])->name('hasil-perangkingan.index');
    Route::put('/hasil/{id}/updateStatus', [HasilController::class, 'updateStatus'])->name('hasil-perangkingan.updateStatus');

    Route::get('pelaksana', [PelaksanaController::class, 'index'])->name('pelaksana.index');
    Route::get('pelaksana/create', [PelaksanaController::class, 'create'])->name('pelaksana.create');
    Route::post('pelaksana/store', [PelaksanaController::class, 'store'])->name('pelaksana.store');
    Route::get('pelaksana/edit/{id}', [PelaksanaController::class, 'edit'])->name('pelaksana.edit');
    Route::put('pelaksana/update/{id}', [PelaksanaController::class, 'update'])->name('pelaksana.update');
    Route::get('pelaksana/delete/{id}', [PelaksanaController::class, 'delete'])->name('pelaksana.delete');

    Route::get('/subbidang', [SubbidangController::class, 'index'])->name('subbidang.index');
    Route::get('/subbidang/create', [SubbidangController::class, 'create'])->name('subbidang.create');
    Route::post('/subbidang/store', [SubbidangController::class, 'store'])->name('subbidang.store');
    Route::get('/subbidang/delete/{id}', [SubbidangController::class, 'delete'])->name('subbidang-delete');

    // Data Portofolio
    Route::get('/portofolio', [PortofolioController::class, 'index'])->name('portofolio.index');
    Route::get('/portofolio/create', [PortofolioController::class, 'create'])->name('portofolio.create');
    Route::post('/portofolio/store', [PortofolioController::class, 'store'])->name('portofolio.store');
    Route::get('/portofolio/edit/{id}', [PortofolioController::class, 'edit'])->name('portofolio.edit');
    Route::put('/portofolio/update/{id}', [PortofolioController::class, 'update'])->name('portofolio.update');
    Route::get('/portofolio/delete/{id}', [PortofolioController::class, 'delete'])->name('portofolio.delete');
});
