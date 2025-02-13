<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('hunter_license', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hunter_id')->constrained()->onDelete('cascade');
            $table->foreignId('license_id')->constrained()->onDelete('cascade');
            $table->string('license_image')->nullable(); // 免状の写真
            $table->date('license_expiry')->nullable(); // 免許の有効期限
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hunter_license');
    }
};
