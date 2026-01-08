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
        Schema::table('etudiants', function (Blueprint $table) {
            // Make it nullable in case some students are not assigned yet
            $table->unsignedBigInteger('enseignant_id')->nullable()->after('id');

            // If you want referential integrity:
            $table->foreign('enseignant_id')
                  ->references('id')
                  ->on('enseignants')
                  ->onDelete('set null'); // or ->onDelete('cascade') if you prefer
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('etudiants', function (Blueprint $table) {
            // Drop FK first, then column
            $table->dropForeign(['enseignant_id']);
            $table->dropColumn('enseignant_id');
        });
    }
};
