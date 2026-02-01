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
        Schema::create('region_stats', function (Blueprint $table) {
            $table->id();
            $table->string('region_name');
            $table->integer('branch_count');
            $table->string('member_count_text');
            $table->string('status')->default('Aktif & Berkembang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('region_stats');
    }
};
