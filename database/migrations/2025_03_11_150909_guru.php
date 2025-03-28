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
        Schema::create('guru', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->enum('jenis_kelamin',['laki-laki','perempuan'])->nullable(false);
            $table->text('alamat')->nullable(false);
            $table->date('tanggal_lahir')->nullable(false);
            $table->string('tempat_lahir',30)->nullable(false);
            $table->text('foto');
            $table->string('nip',18)->default('-');
            $table->string('nomor_telepon',20)->nullable(false);
            $table->timestamps();
            
            $table->foreign('user_id')->on('user')
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
        Schema::dropIfExists('guru');
    }
};
