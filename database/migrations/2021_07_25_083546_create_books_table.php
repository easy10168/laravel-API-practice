<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subcategory_id')->constrained('subcategories');
            $table->string('name')->comment('書名');
            $table->string('slug')->comment('在URL中代替ID');
            $table->string('author')->comment('作者名稱');
            $table->string('publisher')->comment('出版社名稱');
            $table->date('publish_date')->comment('出版日期');
            $table->text('description')->nullable()->comment('書本介紹');
            $table->integer('price')->comment('定價');
            $table->integer('quantity')->default(0)->comment('庫存數量');
            $table->enum('status', ['out_of_stock', 'in_stock', 'running_low'])->comment('out_of_stock：庫存不足，in_stock：庫存充足，running_low：庫存稀少(<10)');
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
        Schema::dropIfExists('books');
    }
}
