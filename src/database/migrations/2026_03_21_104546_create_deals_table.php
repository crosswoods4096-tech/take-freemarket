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
            $table->foreignId('buyer_id')
                ->constrained('users')
                ->onDelete('cascade');

            // ステータス（必要に応じて）
            $table->string('status')->default('paid');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deals');
    }
}
