<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = implode(' ', $this->faker->words(2));
        $slug = Str::slug($name);
        $quantity = $this->faker->numberBetween(0, 1000);
        $status = 'in_stock';
        if ($quantity == 0) $status = 'out_of_stock';
        if ($quantity < 10) $status = 'running_low';
        return [
            'subcategory_id' => Subcategory::inRandomOrder()->first()->id,
            'name' => $name,
            'slug' => $slug,
            'author' => $this->faker->name(),
            'publisher' => $this->faker->firstName() . ' pulisher',
            'publish_date' => $this->faker->date(),
            'price' => $this->faker->numberBetween(10, 999) * 10,
            'quantity' => $quantity,
            'description' => $this->faker->realText(300),
            'status' => $status,
        ];
    }
}
