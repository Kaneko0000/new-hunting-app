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
        Schema::table('hunters', function (Blueprint $table) {
            $table->string('license_type')->nullable()->after('region');
            $table->string('license_image')->nullable()->after('license_type'); // 狩猟免状の写真
            $table->date('license_expiry')->nullable()->after('license_image'); // 狩猟免状の有効期限
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hunters', function (Blueprint $table) {
            $table->dropColumn(['license_type', 'license_image', 'license_expiry']);
        });
    }
};
