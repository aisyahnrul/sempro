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
        Schema::create('status_histori', function (Blueprint $table) {
            $table->id('id_histori');
            $table->foreignId('id_prop')->constrained('proposal', 'id_prop');
            $table->string('status', 30);
            $table->foreignId('changed_by')->constrained('users', 'id_user');
            $table->timestamp('changed_at');
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_histori');
    }
};
