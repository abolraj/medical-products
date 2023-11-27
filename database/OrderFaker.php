<?php
namespace DB\Faker;

use Model\Offer;
use Model\Order;
use Model\Product;
use Model\User;

class OrderFaker extends Faker {
    public static function generate(): array
    {
        $faker = static::create_faker();
        $product_ids = array_column(Product::all(['id']), 'id');
        $user_ids = array_column(User::all(['id']), 'id');
        $user_id = $faker->randomElement($user_ids);
        $product_id = $faker->randomElement($product_ids);
        $product = Product::find($product_id);
        $max_quantity = $product['quantity'];
        $quantity = $faker->numberBetween(1, $max_quantity);       

        // Handle if there is an offer
        if($offer = Offer::take_offer($user_id, $product_id)){
            $offer_value = +$offer['value'];
            $product['price'] = ceil( $product['price'] * (100 - $offer_value) / 100 );
        }

        return [
            'quantity' => $quantity,
            'price' => $product['price'],
            'total_price' => $quantity * $product['price'],
            'is_paid' => $faker->boolean(60),
            'product_id' => $faker->randomElement($product_ids),
            'user_id' => $user_id,
        ];
    }
}