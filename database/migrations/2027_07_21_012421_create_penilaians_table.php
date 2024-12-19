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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelaksana_id')->unsigned()->nullable();
            $table->unsignedBigInteger('sub_kriteria_id')->unsigned()->nullable();
            $table->integer('nilai')->nullable();
            $table->timestamps();

            $table->foreign('pelaksana_id')->references('id')->on('pelaksanas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('sub_kriteria_id')->references('id')->on('sub_kriterias')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
