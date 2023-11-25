<?php
namespace DB\Faker;

class ProductFaker extends Faker {
    public static function generate(): array
    {
        $faker = static::create_faker();
        $image = store($faker->image(), '/images');
        return [
            'name' => 'Product - ' . $faker->numerify('####'),
            'description' => $faker->text(),
            'price' => $faker->numberBetween(100_000, 10_000_000),
            'quantity' => $faker->numberBetween(0, 40),
            'image' => $image,
        ];
    }
}