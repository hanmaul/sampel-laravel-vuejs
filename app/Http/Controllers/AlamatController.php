<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;

class AlamatController extends Controller
{
    public function getDataKota(Request $req)
    {
        $data = Kota::all();
        return $data;
    }
    public function getDataKecamatan(Request $req)
    {
        $kota_id = $req->kota_id;
        $data = Kecamatan::where("kota_id",$kota_id)->get();
        return $data;
    }
    public function getDataKelurahan(Request $req)
    {
        $kecamatan_id = $req->kecamatan_id;
        $data = Kelurahan::where("kecamatan_id",$kecamatan_id)->get();
        return $data;
    }
}
