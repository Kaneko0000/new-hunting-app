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
        Schema::create('hunters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('region'); // ハンターの活動地域
            $table->text('notes')->nullable(); // メモ
            $table->string('password')->nullable(); // パスワードカラムを追加
            $table->string('license_type')->nullable(); // ✅ `after` を削除
            $table->string('license_image')->nullable(); // ✅ `after` を削除
            $table->date('license_expiry')->nullable(); // ✅ `after` を削除
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('role')->default('hunter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hunters');
    }
};
