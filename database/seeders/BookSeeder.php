<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints(); //truncate可能會報
        Book::truncate();
        Book::factory(1000)->create();
        Schema::enableForeignKeyConstraints(); //把關掉的Foreign key constraint打開
    }
}
