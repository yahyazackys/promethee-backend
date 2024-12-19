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
        Schema::create('pelaksanas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_bidang_id')->unsigned()->nullable();
            $table->unsignedBigInteger('calon_pelaksana_id')->unsigned()->nullable();
            $table->unsignedBigInteger('proyek_id')->unsigned()->nullable();
            $table->string('no_kontrak')->nullable();
            $table->integer('nilai_kontrak')->nullable();
            $table->date('tanggal_kontrak')->nullable();
            $table->date('tanggal_selesai_kontrak')->nullable();
            $table->timestamps();

            $table->foreign('sub_bidang_id')->references('id')->on('sub_bidangs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('calon_pelaksana_id')->references('id')->on('calon_pelaksanas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('proyek_id')->references('id')->on('proyeks')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaksanas');
    }
};
