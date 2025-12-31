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
        Schema::table('hero_sections', function (Blueprint $table) {
            $table->string('party_name')->default('Partai Ibu')->after('id');
            $table->string('stat_members')->default('50K+')->after('secondary_button_text');
            $table->string('stat_provinces')->default('34')->after('stat_members');
            $table->string('stat_programs')->default('100+')->after('stat_provinces');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_sections', function (Blueprint $table) {
            $table->dropColumn(['party_name', 'stat_members', 'stat_provinces', 'stat_programs']);
        });
    }
};
