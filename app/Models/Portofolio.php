<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    use HasFactory;
    public $table = "portofolios";
    protected $guarded = ['id'];

    public function pelaksana()
    {
        return $this->belongsTo(Pelaksana::class);
    }
}
