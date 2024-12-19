<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datadiri extends Model
{
    use HasFactory;
    public $table = "calon_pelaksanas";
    protected $guarded = ['id'];
}
