<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKonsumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konsumen', function (Blueprint $table) {
            $table->id();
            $table->string("no_kontrak",20);
            $table->string("nama");
            $table->enum("jenis_kelamin",["Laki-Laki","Perempuan"]);
            $table->foreignId("kota_id")->on("kota");
            $table->foreignId("kecamatan_id")->on("kecamatan");
            $table->foreignId("kelurahan_id")->on("kelurahan");
            $table->string("kode_pos",10);
            $table->string("alamat");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('konsumen');
    }
}
