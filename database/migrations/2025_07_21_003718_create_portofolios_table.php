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
        Schema::create('portofolios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelaksana_id')->unsigned()->nullable();
            $table->string('k1')->nullable();
            $table->string('k2')->nullable();
            $table->string('k3')->nullable();
            $table->string('k4')->nullable();
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
        Schema::dropIfExists('portofolios');
    }
};
