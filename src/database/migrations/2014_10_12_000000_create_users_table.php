<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // 基本情報
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // 追加したいユーザー情報
            $table->string('postcord')->nullable();   // 郵便番号
            $table->string('address')->nullable();    // 住所
            $table->string('building')->nullable();   // 建物名
            $table->string('avatar')->nullable();     // プロフィール画像

            // Laravel 標準
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
