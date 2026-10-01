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
    Schema::create('pengajuan_ganti_bimbingan', function (Blueprint $table) {
    $table->bigIncrements('id_pengajuan');

    $table->foreignId('id_mhs')
        ->constrained('mahasiswa', 'id_mhs')
        ->cascadeOnUpdate();

    $table->foreignId('id_dosen_saat_ini')
        ->nullable()
        ->constrained('dosen', 'id_dosen')
        ->nullOnDelete()
        ->cascadeOnUpdate();

    $table->foreignId('id_dosen_baru')
        ->nullable()
        ->constrained('dosen', 'id_dosen')
        ->nullOnDelete()
        ->cascadeOnUpdate();

    $table->text('alasan');

    $table->string('status', 20)->default('Diajukan');

    $table->foreignId('reviewed_by')
        ->nullable()
        ->constrained('users', 'id_user')
        ->nullOnDelete()
        ->cascadeOnUpdate();

    $table->timestamp('reviewed_at')->nullable();

    $table->text('catatan_prodi')->nullable();

    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_ganti_bimbingan');
    }
};
