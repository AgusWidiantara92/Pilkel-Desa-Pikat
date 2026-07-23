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
        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            $table->string('nkk', 16)->index();
            $table->string('nik', 16)->unique()->index();
            $table->string('nama')->index();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->enum('status_perkawinan', ['B', 'S', 'P'])->default('B'); // B = Belum, S = Sudah, P = Pernah Kawin
            $table->text('alamat')->nullable();
            $table->string('dusun')->nullable()->index();
            
            // Foreign Key to TPS table
            $table->foreignId('tps_id')->constrained('tps')->onDelete('cascade');
            
            // Status Pemilih & Keterangan
            $table->enum('status', ['aktif', 'tms'])->default('aktif')->index(); // tms = Tidak Memenuhi Syarat
            $table->string('keterangan')->nullable();
            $table->timestamps();

            // Composite Indexes for Fast Search
            $table->index(['nama', 'dusun']);
            $table->index(['nik', 'tps_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voters');
    }
};
