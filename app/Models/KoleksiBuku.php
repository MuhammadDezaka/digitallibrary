<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoleksiBuku extends Model
{
    use HasFactory;

    protected $table = "koleksi_pribadi";

    protected $guarded = ['id'];

    public $timestamps = false;

    public function Buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
