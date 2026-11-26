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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'documento')) {
                $table->string('documento', 50)->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'telefono')) {
                $table->string('telefono', 50)->nullable()->after('documento');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'documento')) {
                $table->dropColumn('documento');
            }
            if (Schema::hasColumn('users', 'telefono')) {
                $table->dropColumn('telefono');
            }
        });
    }
};
