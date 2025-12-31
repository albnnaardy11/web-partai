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
        Schema::create('chairperson_messages', function (Blueprint $table) {
            $table->id();
            $table->string('header_badge')->default('Sambutan Ketua Umum');
            $table->string('header_title')->default('Pesan dari Ibu Ketua');
            $table->string('image_path')->nullable();
            $table->string('message_greeting')->default('Assalamu’alaikum warahmatullahi wabarakatuh');
            $table->text('message_content');
            $table->string('signature_greeting')->default('Wassalamu’alaikum warahmatullahi wabarakatuh');
            $table->string('chairperson_name')->default('Ibu Siti Rahmawati');
            $table->string('chairperson_title')->default('Ketua Umum Partai Ibu');
            $table->string('philosophy_text')->default('Indonesia adalah keluarga besar kita');
            $table->string('commitment_text')->default('Kepedulian untuk setiap anak bangsa');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chairperson_messages');
    }
};
