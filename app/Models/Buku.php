<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = "buku";

    protected $guarded =['id'];

    public $timestamps = false;

     /**
     * Get the kategori associated with the buku.
     */
    public function koleksiPribadi()
    {
        return $this->belongsToMany(Kategori::class, 'kategori_buku_relasi', 'buku_id', 'kategori_id');
    }
}
