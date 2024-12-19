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
        Schema::create('anggarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelaksana_id')->unsigned()->nullable();
            $table->integer('total_anggaran')->nullable();
            $table->integer('sisa_anggaran')->nullable();
            $table->integer('termin1')->nullable();
            $table->string('termin1_bukti')->nullable();
            $table->integer('termin2')->nullable();
            $table->string('termin2_bukti')->nullable();
            $table->integer('termin3')->nullable();
            $table->string('termin3_bukti')->nullable();
            $table->integer('termin4')->nullable();
            $table->string('termin4_bukti')->nullable();
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
        Schema::dropIfExists('anggarans');
    }
};
