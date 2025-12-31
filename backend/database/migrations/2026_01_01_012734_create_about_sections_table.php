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
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('header_badge')->default('Tentang Kami');
            $table->string('header_title');
            $table->text('header_description');
            
            $table->string('feature_1_title');
            $table->text('feature_1_description');
            
            $table->string('feature_2_title');
            $table->text('feature_2_description');
            
            $table->string('feature_3_title');
            $table->text('feature_3_description');
            
            $table->string('banner_title');
            $table->text('banner_description');
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_sections');
    }
};
