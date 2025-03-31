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
        Schema::create('hunter_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hunter_id')->constrained('hunters')->onDelete('cascade');
            $table->foreignId('animal_id')->constrained('animals')->onDelete('cascade');
            $table->foreignId('weather_id')->constrained('weather_conditions')->onDelete('cascade');
            $table->decimal('latitude', 10, 7); // 緯度
            $table->decimal('longitude', 10, 7); // 経度
            $table->date('capture_date'); // 捕獲日
            $table->text('comments')->nullable(); // コメント
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hunter_logs');
    }
};
