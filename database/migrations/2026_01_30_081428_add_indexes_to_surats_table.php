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
        Schema::table('surats', function (Blueprint $table) {
            $table->index('reference_number');
            $table->index('subject');
            $table->index('sender');
            $table->index('recipient');
            $table->index('status');
            $table->index('date');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surats', function (Blueprint $table) {
            $table->dropIndex(['reference_number']);
            $table->dropIndex(['subject']);
            $table->dropIndex(['sender']);
            $table->dropIndex(['recipient']);
            $table->dropIndex(['status']);
            $table->dropIndex(['date']);
            $table->dropIndex(['type']);
        });
    }
};
