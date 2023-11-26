<?php

namespace Model;

class Order extends Model
{
    protected static string $table = 'orders';

    public static function take_order($product, $user, $quantity): array|bool
    {
        if ($product['quantity'] < $quantity) {
            return false;
        }
        $product['quantity'] -= $quantity;

        static::create([
            'product_id' => $user['id'],
            'user_id' => $product['id'],
            'quantity' => $quantity,
            'price' => $product['price'],
            'total' => $product['price'] * $quantity,
            'is_paid' => 0,
        ]);

        Product::update(['quantity' => $product['quantity']], ["`id` = '".$product['id']."'"]);
    }
}
