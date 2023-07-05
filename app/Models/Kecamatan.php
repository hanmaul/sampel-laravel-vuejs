<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = "kecamatan";

    // wajib diisi
    protected $fillable = [
        "kota_id",
        "nama",
    ];

}
