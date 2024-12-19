<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    use HasFactory;
    public $table = "hasils";
    protected $guarded = ['id'];

    public function pelaksana()
    {
        return $this->belongsTo(Pelaksana::class, 'pelaksana_id');
    }
}
