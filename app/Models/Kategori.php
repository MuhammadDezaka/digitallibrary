<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = "kategori_buku";

    protected $guarded = ['id'];

    public $timestamps = false;

    public function bukus()
    {
        return $this->belongsToMany(Buku::class, 'kategori_buku_relasi', 'kategori_id', 'buku_id');
    }
}
