<?php

namespace Model;

use Exception;

class Order extends Model
{
    protected static string $table = 'orders';

    public static function take_order($product, $user, $quantity): array|bool
    {
        if ($product['quantity'] < $quantity) {
            return false;
        }
        $product['quantity'] -= $quantity;

        try{
            if($offer = Offer::take_offer($user['id'], $product['id'])){
                $offer_value = +$offer['value'];
                $product['price'] = ceil( $product['price'] * (100 - $offer_value) / 100 );
            }
            report('Take Order With Offer', $offer);
    
            static::create([
                'product_id' => $product['id'],
                'user_id' => $user['id'],
                'quantity' => $quantity,
                'price' => $product['price'],
                'total_price' => $product['price'] * $quantity,
                'is_paid' => 0,
            ]);
    
            Product::update(['quantity' => $product['quantity']], ["`id` = '".$product['id']."'"]);
    
            return true;
        }catch(\Exception $e){
            report('Error Take Order', $e->getMessage());
            return false;
        }

    }
}
