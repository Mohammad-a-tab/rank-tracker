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
        Schema::create('keywords_ranks', function (Blueprint $table) {
           $table->id();
           $table->integer('first_rank')->nullable();
           $table->integer('latest_rank')->nullable();
           $table->foreignId('site_detail_id')->nullable()->constrained('site_details');
           $table->foreignId('keyword_id')->nullable()->constrained('keywords');
           $table->foreignId('site_id')->nullable()->constrained('sites');
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keywords_ranks');
    }
};
