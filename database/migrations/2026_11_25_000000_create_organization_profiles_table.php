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
        Schema::create('organization_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('nama_organisasi');
            $table->text('deskripsi_singkat');
            $table->text('sejarah');
            $table->text('visi');
            $table->text('misi');
            $table->string('alamat');
            $table->string('email')->nullable();
            $table->string('telepon', 50)->nullable();
            $table->string('whatsapp', 50)->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('google_maps_url')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('logo_public_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_profiles');
    }
};
