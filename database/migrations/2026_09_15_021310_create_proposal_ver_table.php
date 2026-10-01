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
        Schema::create('proposal_ver', function (Blueprint $table) {
            $table->id('id_ver');
            $table->foreignId('id_prop')->constrained('proposal', 'id_prop');
            $table->unsignedInteger('versi');
            $table->string('file_path', 255);
            $table->foreignId('upload_by')->constrained('users', 'id_user');    
            $table->timestamp('uploaded_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_ver');
    }
};
