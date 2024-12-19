<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subkriteria extends Model
{
    use HasFactory;
    public $table = "sub_kriterias";
    protected $guarded = ['id'];

    public function kriteria()
    {
        return $this->belongsTo(Kriterias::class, 'kriteria_id');
    }
}
