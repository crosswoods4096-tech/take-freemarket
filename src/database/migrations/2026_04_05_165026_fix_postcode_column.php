<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixPostcodeColumn extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // 新しいカラムを追加
            $table->string('postcode')->nullable()->after('id');
        });

        // 古い postcord の値を新しい postcode にコピー
        DB::statement('UPDATE users SET postcode = postcord');

        Schema::table('users', function (Blueprint $table) {
            // 古い postcord カラムを削除
            $table->dropColumn('postcord');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // 元に戻す処理（必要なら）
            $table->string('postcord')->nullable()->after('id');
        });

        DB::statement('UPDATE users SET postcord = postcode');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('postcode');
        });
    }
}
