<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('hunter_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hunter_id')->constrained()->onDelete('cascade'); // ハンターのID
            $table->date('date');       // 記録日
            $table->time('time')->nullable(); // `time`カラムを追加 (修正ポイント)
            $table->string('location'); // 場所
            $table->string('species');  // 動物の種類
            $table->decimal('weight', 8, 2)->nullable(); // 重量（オプション）
            $table->text('notes')->nullable(); // メモ（オプション）
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hunter_logs');
    }
};
