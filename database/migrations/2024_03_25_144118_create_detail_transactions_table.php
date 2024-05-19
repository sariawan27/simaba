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
        Schema::create('detail_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pengajuan_id")->nullable();
            $table->unsignedBigInteger("barang_id")->nullable();
            $table->integer("quantity");
            $table->timestamps();

            $table->foreign("barang_id")->references("id")->on("barang")->onDelete('cascade');
            $table->foreign("pengajuan_id")->references("id")->on("pengajuan")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pengajuan');
    }
};
