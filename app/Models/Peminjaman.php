<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = "peminjaman";

    protected $guarded = ['id'];

    public $timestamps = false;

     /**
     * Relation To Provinces
     * @return object
     */
    public function Buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
