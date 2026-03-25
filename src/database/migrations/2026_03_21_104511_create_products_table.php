<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // 出品者
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // 商品情報
            $table->string('name');
            $table->integer('price');
            $table->string('brand')->nullable();
            $table->text('description');
            $table->string('image_path');
            $table->string('condition');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
