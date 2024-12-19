<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProsesSeleksi extends Model
{
    use HasFactory;
    protected $table = 'hasils';
    protected $guarded = ['id'];
}

