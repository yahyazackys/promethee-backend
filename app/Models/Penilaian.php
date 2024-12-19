<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;
    public $table = "penilaians";
    protected $guarded = ['id'];

    public function pelaksana()
    {
        return $this->belongsTo(Pelaksana::class, 'pelaksana_id');
    }
    public function subkriteria()
    {
        return $this->belongsTo(Subkriteria::class, 'sub_kriteria_id');
    }
}