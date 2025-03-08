<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('site_details', function (Blueprint $table) {
            $table->unsignedBigInteger('keyword_id')->nullable()->after('site_id');
            $table->foreign('keyword_id')->references('id')->on('keywords')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_details', function (Blueprint $table) {
            $table->dropForeign(['keyword_id']);
            $table->dropColumn('keyword_id');
        });
    }
};
