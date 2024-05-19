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
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pengajuan_id")->nullable();
            $table->enum('rating', ['1', '2', '3', '4', '5'])->nullable();
            $table->text('catatan_ulasan');
            $table->timestamps();

            $table->foreign("pengajuan_id")->references("id")->on("pengajuan")->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
