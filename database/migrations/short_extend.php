<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('migrations', function (Blueprint $table) {
            $table->string('migration', 255)->change();
        });
    }

    public function down(): void
    {
        Schema::table('migrations', function (Blueprint $table) {
            $table->string('migration', 191)->change();
        });
    }
};
