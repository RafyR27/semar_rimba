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
        Schema::table('organization_profiles', function (Blueprint $table): void {
            $table->unsignedTinyInteger('singleton_flag')->default(1)->after('id');
            $table->unique('singleton_flag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organization_profiles', function (Blueprint $table): void {
            $table->dropUnique(['singleton_flag']);
            $table->dropColumn('singleton_flag');
        });
    }
};
