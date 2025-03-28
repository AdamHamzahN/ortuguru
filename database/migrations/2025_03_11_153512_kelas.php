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
        Schema::create('kelas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('guru_id');
            $table->uuid('jurusan_id');
            $table->uuid('angkatan_id');
            $table->string('nama_kelas',20)->nullable(false);
            $table->enum('status',['lulus','belum lulus'])->default('belum lulus');
            $table->timestamps();

            $table->foreign('guru_id')->on('guru')
            ->references('id')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('jurusan_id')->on('jurusan')
            ->references('id')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('angkatan_id')->on('angkatan')
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
        Schema::dropIfExists('kelas');
    }
};
