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
        Schema::create('siswa', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kelas_id');
            $table->uuid('orang_tua_id');
            $table->string('nis',20)->nullable(false);
            $table->string('nisn',15)->nullable(false);
            $table->enum('jenis_kelamin',['laki-laki','perempuan']);
            $table->string('tempat_lahir',30)->nullable(false);
            $table->date('tanggal_lahir')->nullable(false);
            $table->text('alamat')->nullable(false);
            $table->text('foto');
            $table->text('ijazah_smp');
            $table->text('akte_kelahiran');
            $table->text('kartu_keluarga');
            $table->timestamps();

            $table->foreign('orang_tua_id')->on('orang_tua_siswa')
            ->references('id')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('kelas_id')->on('kelas')
            ->references('id')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
