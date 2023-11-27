<?php
namespace DB\Faker;

class ProductFaker extends Faker {
    public static function generate(): array
    {
        $faker = static::create_faker();
        $image = 'https://d12oja0ew7x0i8.cloudfront.net/images/Article_Images/ImageForArticle_22159_16692792485341491.jpg';
        $image = store($image, '/images');
        return [
            'name' => 'Product - ' . $faker->numerify('####'),
            'description' => $faker->text(),
            'price' => $faker->numberBetween(1, 100)*10,
            'quantity' => $faker->numberBetween(0, 40),
            'image' => $image,
        ];
    }
}