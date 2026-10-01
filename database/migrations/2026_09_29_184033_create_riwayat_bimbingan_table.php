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
        Schema::create('riwayat_bimbingan', function (Blueprint $table) {
        $table->bigIncrements('id_riwayat');

        $table->foreignId('id_mhs')
            ->constrained('mahasiswa', 'id_mhs')
            ->cascadeOnUpdate();

        $table->foreignId('id_dosen_lama')
            ->nullable()
            ->constrained('dosen', 'id_dosen')
            ->nullOnDelete()
            ->cascadeOnUpdate();

        $table->foreignId('id_dosen_baru')
            ->nullable()
            ->constrained('dosen', 'id_dosen')
            ->nullOnDelete()
            ->cascadeOnUpdate();

        $table->foreignId('changed_by')
            ->constrained('users', 'id_user')
            ->cascadeOnUpdate();

        $table->text('alasan');
        $table->timestamp('changed_at');

        $table->string('sumber', 20)->default('prodi');

    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_bimbingan');
    }
};
