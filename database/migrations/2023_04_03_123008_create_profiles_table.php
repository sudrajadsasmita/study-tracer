<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nim');
            $table->unsignedBigInteger('prodi_id');
            $table->double('ipk');
            $table->year('tahun_masuk');
            $table->year('tahun_lulus');
            $table->enum('status_bekerja', [
                "YA",
                "TIDAK"
            ]);
            $table->text('saran_prodi')->nullable();
            $table->text('alamat_perusahaan')->nullable();
            $table->string('jabatan')->nullable();
            $table->integer('lama_bekerja')->nullable();
            $table->bigInteger('gaji')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
