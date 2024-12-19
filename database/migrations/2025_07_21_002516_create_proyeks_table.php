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
        Schema::create('proyeks', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('pelaksana_id')->unsigned()->nullable();
            // $table->string('nama')->nullable();
            $table->string('nama_proyek')->nullable();
            $table->string('bukti1')->nullable();
            $table->string('bukti2')->nullable();
            $table->string('bukti3')->nullable();
            $table->string('bukti4')->nullable();
            $table->integer('progress')->nullable();
            $table->string('laporan_lapangan_bersama')->nullable();
            $table->timestamps();

            // $table->foreign('pelaksana_id')->references('id')->on('pelaksanas')
            //     ->onDelete('cascade')
            //     ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyeks');
    }
};
