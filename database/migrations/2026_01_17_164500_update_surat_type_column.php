<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surats', function (Blueprint $table) {
            // Drop enum column and recreate as string or new enum
            $table->dropColumn('type');
        });

        Schema::table('surats', function (Blueprint $table) {
            $table->string('type')->after('id'); // Flexible type: Izin, Dispensasi, Sakit, Beasiswa
        });
    }

    public function down(): void
    {
        Schema::table('surats', function (Blueprint $table) {
             $table->dropColumn('type');
        });
        Schema::table('surats', function (Blueprint $table) {
            $table->enum('type', ['masuk', 'keluar'])->after('id');
        });
    }
};
