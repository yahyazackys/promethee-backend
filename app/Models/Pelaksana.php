<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaksana extends Model
{
    use HasFactory;
    public $table = "pelaksanas";
    protected $guarded = ['id'];

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'pelaksana_id');
    }

    public function anggarans()
    {
        return $this->hasMany(Anggaran::class, 'pelaksana_id');
    }

    public function portofolios()
    {
        return $this->hasMany(Portofolio::class, 'pelaksana_id');
    }

    public function subbidang()
    {
        return $this->belongsTo(Subbidang::class, 'sub_bidang_id');
    }

    public function calonpelaksana()
    {
        return $this->belongsTo(CalonPelaksana::class, 'calon_pelaksana_id');
    }

    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'proyek_id');
    }
}