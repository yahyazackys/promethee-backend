<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonPelaksana extends Model
{
    use HasFactory;
    public $table = "calon_pelaksanas";
    protected $guarded = ['id'];

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'calon_pelaksana_id');
    }

    public function hasils()
    {
        return $this->hasMany(Hasil::class, 'calon_pelaksana_id');
    }
}
