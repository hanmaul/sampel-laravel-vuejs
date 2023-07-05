<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsumen extends Model
{
    use HasFactory;

    protected $table = "konsumen";

    public function kota()
    {
        return $this->belongsTo(Kota::class,"kota_id","id");
    }
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class,"kecamatan_id","id");
    }
    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class,"kelurahan_id","id");
    }
}
