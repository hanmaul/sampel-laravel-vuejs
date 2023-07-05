<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kecamatan;
use App\Models\Kelurahan;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $getJatiasih = Kecamatan::where("nama","Jatiasih")->first();
        $jatiasih_id = $getJatiasih->id;

        $getPondokGede = Kecamatan::where("nama","Pondok Gede")->first();
        $pondokGede_id = $getPondokGede->id;

        $getCileungsi = Kecamatan::where("nama","Cileungsi")->first();
        $cileungsi_id = $getCileungsi->id;

        $getCibubur = Kecamatan::where("nama","Cibubur")->first();
        $cibubur_id = $getCibubur->id;

        $getJakartaBarat = Kecamatan::where("nama","Jakarta Barat")->first();
        $jakartaBarat_id = $getJakartaBarat->id;

        $getJakartaTimur = Kecamatan::where("nama","Jakarta Timur")->first();
        $jakartaTimur_id = $getJakartaTimur->id;

        Kelurahan::insert([
            [
                "kecamatan_id" => $jatiasih_id,
                "nama" => "Kecamatan 1",
            ],[
                "kecamatan_id" => $pondokGede_id,
                "nama" => "Kecamatan 2",
            ],[
                "kecamatan_id" => $cileungsi_id,
                "nama" => "Kecamatan 3",
            ],[
                "kecamatan_id" => $cibubur_id,
                "nama" => "Kecamatan 4",
            ],[
                "kecamatan_id" => $jakartaBarat_id,
                "nama" => "Kecamatan 5",
            ],[
                "kecamatan_id" => $jakartaTimur_id,
                "nama" => "Kecamatan 6",
            ],
        ]);
    }
}
