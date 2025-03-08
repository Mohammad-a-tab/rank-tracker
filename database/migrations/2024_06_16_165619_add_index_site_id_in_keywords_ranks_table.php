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
        Schema::table('keywords_ranks', function (Blueprint $table) {
            $table->index('site_id');
            $table->index('keyword_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keywords_ranks', function (Blueprint $table) {
            $table->dropIndex('keywords_ranks_site_id_index');
            $table->dropIndex('keywords_ranks_keyword_id_index');
        });
    }
};
