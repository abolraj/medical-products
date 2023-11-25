<?php
namespace DB\Faker;

use Model\Order;
use Model\Product;
use Model\User;

class OrderFaker extends Faker {
    public static function generate(): array
    {
        $faker = static::create_faker();
        $product_ids = array_column(Product::all(['id']), 'id');
        $user_ids = array_column(User::all(['id']), 'id');
        $product_id = $faker->randomElement($product_ids);
        $product = Product::find($product_id);
        $max_quantity = $product['quantity'];
        $quantity = $faker->numberBetween(1, $max_quantity);       

        return [
            'quantity' => $quantity,
            'price' => $product['price'],
            'total_price' => $quantity * $product['price'],
            'product_id' => $faker->randomElement($product_ids),
            'user_id' => $faker->randomElement($user_ids),
        ];
    }
}