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

        try {
            if ($offer = Offer::take_offer($user['id'], $product['id'])) {
                $offer_value = +$offer['value'];
                $product['price'] = ceil($product['price'] * (100 - $offer_value) / 100);
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

            Product::update(['quantity' => $product['quantity']], ["`id` = '" . $product['id'] . "'"]);

            return true;
        } catch (\Exception $e) {
            report('Error Take Order', $e->getMessage());
            return false;
        }
    }

    public static function cancel_order($order_id): array|bool
    {
        try {
            $order = static::find($order_id);
            if (!$order || $order['is_paid'])
                return $order;
            $user_id = $order['user_id'];
            $product_id = $order['product_id'];
            // Make related offer not consumed
            Offer::update(
                [
                    'consumed_at' => null
                ],
                [
                    "`user_id` = '$user_id'",
                    "`product_id` = '$product_id'",
                ]
            );
    
            // Give quantity to product
            $product = Product::find($product_id);
            Product::update(
                [
                    'quantity' => $product['quantity'] + $order['quantity']
                ],
                [
                    "`id` = '$product_id'",
                ]
            );
    
            // Delete the order
            static::delete(["id = `$order_id`"]);  
            
            return $order;
        } catch (\Exception $e) {
            report('Error Cancel Order', $e->getMessage());
            return false;
        }
    }

    /**
     * Pay the order
     *
     * @param int $order_id
     * @return array|boolean
     */
    public static function pay_order($order_id): array|bool{
        try {
            $order = static::find($order_id);
            if(!$order || $order['is_paid'])
                return false;

            static::update(
                [
                    'is_paid' => true,
                ],
                [
                    " `id` = '$order_id' ",
                    " `is_paid` = 0 ",
                ]
            );
        }catch(\Exception $e){
            report('Error Pay Order', $e->getMessage());
            return false;
        }
    }
}
