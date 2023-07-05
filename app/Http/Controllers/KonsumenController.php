<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsumen;

class KonsumenController extends Controller
{
    public function getData(Request $req)
    {
        $data = Konsumen::with(["kota","kecamatan","kelurahan"])->paginate(10);
        return $data;
    }
    public function simpanData(Request $req)
    {
        $req->validate([
            "no_kontrak"=>"required",
            "nama"=>"required",
            "jenis_kelamin"=>"required",
            "kota_id"=>"required",
            "kecamatan_id"=>"required",
            "kelurahan_id"=>"required",
            "kode_pos"=>"required",
            "alamat"=>"required",
        ],[
            "required" => "Wajib Diisi"
        ]);

        $konsumen_id = $req->konsumen_id;
        $no_kontrak = $req->no_kontrak;
        $nama = $req->nama;
        $jenis_kelamin = $req->jenis_kelamin;
        $kota_id = $req->kota_id;
        $kecamatan_id = $req->kecamatan_id;
        $kelurahan_id = $req->kelurahan_id;
        $kode_pos = $req->kode_pos;
        $alamat = $req->alamat;

        if($konsumen_id){
            $kons = Konsumen::find($konsumen_id);
        }else{
            $kons = new Konsumen;
        }
        $kons->no_kontrak = $no_kontrak;
        $kons->nama = $nama;
        $kons->jenis_kelamin = $jenis_kelamin;
        $kons->kota_id = $kota_id;
        $kons->kecamatan_id = $kecamatan_id;
        $kons->kelurahan_id = $kelurahan_id;
        $kons->kode_pos = $kode_pos;
        $kons->alamat = $alamat;
        $kons->save();

        return back();
    }

    public function hapusData(Request $req)
    {
        $konsumen_id = $req->konsumen_id;

        $data = Konsumen::find($konsumen_id);
        $data->delete();

        return [
            "status" => "success"
        ];
    }
}
