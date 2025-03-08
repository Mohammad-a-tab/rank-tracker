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
        Schema::table('site_details', function (Blueprint $table) {
            $table->index('site_id');
        });

        Schema::table('site_details', function (Blueprint $table) {
            $table->index('created_at');
        });

        Schema::table('site_details', function (Blueprint $table) {
            $table->index('rank');
        });

        Schema::table('site_details', function (Blueprint $table) {
            $table->index('keyword_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_details', function (Blueprint $table) {
            $table->dropIndex('site_id');
        });

        Schema::table('site_details', function (Blueprint $table) {
            $table->dropIndex('created_at');
        });

        Schema::table('site_details', function (Blueprint $table) {
            $table->dropIndex('rank');
        });

        Schema::table('site_details', function (Blueprint $table) {
            $table->dropIndex('keyword_id');
        });
    }
};
