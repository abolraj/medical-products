<?php
namespace DB\Faker;

use Model\Offer;
use Model\Product;
use Model\User;

class OfferFaker extends Faker {
    public static function generate(): array
    {
        $faker = static::create_faker();
        $product_ids = array_column(Product::all(['id']), 'id');
        $user_ids = array_column(User::all(['id']), 'id');
        $user_id = $faker->randomElement($user_ids);
        $user_offers = User::offers($user_id);
        $product_ids = array_diff($product_ids, array_column($user_offers, 'product_id'));
        if(empty($product_ids))
            return [];
        $expired = $faker->dateTimeBetween('+1 week', '+3 month')->format('Y-m-d H:i:s');

        $row = [
            'user_id' => $user_id,
            'product_id' => $faker->randomElement($product_ids),
            'value' => $faker->numberBetween(5, 99),
            'expired_at' => $expired,
        ];

        // if($faker->boolean(30)){
        //     $row['consumed_at'] = $faker->dateTimeBetween('now', $expired)->format('Y-m-d H:i:s');
        // }

        return $row;
    }
}