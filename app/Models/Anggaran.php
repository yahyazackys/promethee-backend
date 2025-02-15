<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    use HasFactory;
    public $table = "anggarans";
    protected $guarded = ['id'];

    public function pelaksana()
    {
        return $this->belongsTo(Pelaksana::class, 'pelaksana_id');
    }
    
}
