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
        Schema::create('hasils', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelaksana_id')->unsigned()->nullable();
            $table->double('lev')->nullable();
            $table->double('ent')->nullable();
            $table->double('net')->nullable();
            $table->date('dari_tgl')->nullable();
            $table->date('sampai_tgl')->nullable();
            $table->enum('status', ['proses', 'diajukan', 'diterima'])->nullable();
            $table->timestamps();

            $table->foreign('pelaksana_id')->references('id')->on('pelaksanas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasils');
    }
};
