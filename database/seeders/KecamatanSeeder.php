<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kota;
use App\Models\Kecamatan;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $getKotaBekasi = Kota::where("nama","Bekasi")->first();
        $bekasi_id = $getKotaBekasi->id;

        $getKotaBogor = Kota::where("nama","Bogor")->first();
        $bogor_id = $getKotaBogor->id;

        $getKotaJakarta = Kota::where("nama","Jakarta")->first();
        $jakarta_id = $getKotaJakarta->id;

        Kecamatan::insert([
            [
                "kota_id" => $bekasi_id,
                "nama" => "Jatiasih",
            ],[
                "kota_id" => $bekasi_id,
                "nama" => "Pondok Gede",
            ],[
                "kota_id" => $bogor_id,
                "nama" => "Cileungsi",
            ],[
                "kota_id" => $bogor_id,
                "nama" => "Cibubur",
            ],[
                "kota_id" => $jakarta_id,
                "nama" => "Jakarta Barat",
            ],[
                "kota_id" => $jakarta_id,
                "nama" => "Jakarta Timur",
            ],
        ]);
    }
}
