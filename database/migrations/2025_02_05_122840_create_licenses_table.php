<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 狩猟免許の種類
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('licenses');
    }
};

