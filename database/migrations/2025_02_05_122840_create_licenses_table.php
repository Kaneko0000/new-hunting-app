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

        // 免許の種類を事前登録
        DB::table('licenses')->insert([
            ['name' => 'わな猟'],
            ['name' => '網猟'],
            ['name' => '第一種'],
            ['name' => '第二種'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('licenses');
    }
};

