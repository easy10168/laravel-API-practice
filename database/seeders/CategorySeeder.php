<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints(); //truncate可能會報Foreign key constraint的錯，這邊暫時關掉

        Subcategory::truncate(); //清空資料,不然他會一直增加
        Category::truncate(); //清空資料,不然他會一直增加

        Category::factory(10)->create();
        Subcategory::factory(25)->create();

        Schema::enableForeignKeyConstraints(); //把關掉的Foreign key constraint打開
    }
}
