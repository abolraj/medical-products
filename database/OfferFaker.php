<?php
namespace DB\Faker;

use Model\Product;

class OfferFaker extends Faker {
    public static function generate(): array
    {
        $faker = static::create_faker();
        $product_ids = array_column(Product::all(['id']), 'id');
        
        return [
            'product_id' => $faker->randomElement($product_ids),
            'value' => $faker->numberBetween(5, 99),
        ];
    }
}