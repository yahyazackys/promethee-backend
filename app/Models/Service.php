<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    public $table = "services";
    protected $guarded = ['id'];

    public function news()
    {
        return $this->hasmany(News::class);
    }
}
