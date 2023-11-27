<?php

namespace Model;

class Offer extends Model
{
    protected static string $table = 'offers';

    public static function offer($user_id, $product_id): array|bool{
        return static::read(
            ['*'],
            [
                "`user_id` = '$user_id'",
                "`product_id` = '$product_id'",
            ]
        );
    }
    
    public static function take_offer($user_id, $product_id): array|bool
    {
        $offer = static::offer($user_id, $product_id);
        // Handle if there is an offer
        if ($offer) {
            $offer = $offer[0];
            if (!$offer['consumed_at'] && strtotime($offer['expired_at']) >= time()) {
                static::update(
                    [
                        'consumed_at' => date('Y-m-d H:i:s', time()),
                    ],
                    [
                        "`id` = '".$offer['id']."'"
                    ]
                );
                return $offer;
            } else {
                return false;
            }
        }
        return false;
    }
}
