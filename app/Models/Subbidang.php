<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subbidang extends Model
{
    use HasFactory;
    public $table = "sub_bidangs";
    protected $guarded = ['id'];
}
