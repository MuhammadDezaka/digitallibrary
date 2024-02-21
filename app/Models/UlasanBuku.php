<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanBuku extends Model
{
    use HasFactory;

    protected $table = "ulasan_buku";

    protected $guarded = ['id'];

    public $timestamps = false;

    public function Buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
