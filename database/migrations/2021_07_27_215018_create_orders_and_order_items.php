<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersAndOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('cart_id');
            $table->enum('status', ['pending', 'is_shipping', 'finished', 'canceled'])->comment('狀態：pending待處理、is_shipping運送中、finished訂單完成、canceled訂單取消');
            $table->string('email')->comment('收件者信箱');
            $table->string('phone')->comment('收件者電話');
            $table->string('address', 255)->comment('收件地址');
            $table->text('comment')->comment('備註');
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id');
            $table->foreignId('order_id');
            $table->string('name')->comment('商品名稱');
            $table->integer('price')->comment('購買價');
            $table->integer('quantity')->default(0)->comment('購買數量');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_and_order_items');
    }
}
