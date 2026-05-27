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
        Schema::table('strudents', function (Blueprint $table) {
            $table->foreignId('user_account_id')->nullable()->constrained('user_accounts')->after('degree_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('strudents', function (Blueprint $table) {
            $table->dropColumn('user_account_id');
        });
    }
};
