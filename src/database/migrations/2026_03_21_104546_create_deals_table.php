<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealsTable extends Migration
{
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();

            // 購入された商品
            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade');

            // 購入者
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('postcode');   // 郵便番号
            $table->string('address');    // 住所
            $table->string('building');   // 建物名

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deals');
    }
}
