<?php
namespace DB\Faker;

use Model\Offer;
use Model\Product;

class OfferFaker extends Faker {
    public static function generate(): array
    {
        $faker = static::create_faker();
        $product_ids = array_column(Product::all(['id']), 'id');
        $product_ids = array_diff($product_ids, array_column(Offer::all(['product_id']), 'product_id'));
        if(empty($product_ids))
            return [];

        return [
            'product_id' => $faker->randomElement($product_ids),
            'value' => $faker->numberBetween(5, 99),
            'expired_at' => $faker->dateTimeBetween('+1 week', '+3 month')->format('Y-m-d H:i:s'),
        ];
    }
}