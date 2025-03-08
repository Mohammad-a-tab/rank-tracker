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
        Schema::create('search_results', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('keyword_id')->nullable();
            $table->unsignedBigInteger('external_keyword_id')->nullable();

            $table->text('title')->nullable();
            $table->string('url')->nullable();
            $table->text('full_url')->nullable();

            $table->text('description')->nullable();
            $table->integer('rank')->nullable();

            $table->timestamps();

            $table->foreign('keyword_id')->references('id')->on('keywords')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_results');
    }
};
