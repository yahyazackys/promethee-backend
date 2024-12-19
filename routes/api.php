<?php

use App\Http\Controllers\AnggaranController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\ApiJobController;
use App\Http\Controllers\Api\ApiEventController;
use App\Http\Controllers\Api\ApiNewController;
use App\Http\Controllers\Api\ApiConsultantController;
use App\Http\Controllers\Api\ApiForumController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\ApiBannerController;
use Illuminate\Support\Facades\Mail;

// Route::get('/get-proyeks-by-pelaksana', [AnggaranController::class, 'getProyeksByPelaksana'])->name('getProyeksByPelaksana');