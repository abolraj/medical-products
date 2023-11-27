<?php

use DB\Faker\OfferFaker;
use DB\Faker\OrderFaker;
use DB\Faker\ProductFaker;
use DB\Faker\UserFaker;
use Model\Offer;
use Model\Order;
use Model\Product;
use Model\User;

// Seed your database entities here
echo "Seeding ...\n";

// Seed User fake
echo "User ...";
for($i = 0; $i < 10; $i++){
    $data = UserFaker::generate();
    User::create($data);
    echo "+";

}
echo "Ok\n";


// Seed Product fake
echo "Product ...";
for($i = 0; $i < 30; $i++){
    $data = ProductFaker::generate();
    Product::create($data);
    echo "+";
}
echo "Ok\n";


// Seed Offer fake
echo "Offer ...";
for($i = 0; $i < 100; $i++){
    $data = OfferFaker::generate();
    Offer::create($data);
    echo "+";
}
echo "Ok\n";


// Seed Order fake
echo "Order ...";
for($i = 0; $i < 60; $i++){
    $data = OrderFaker::generate();
    Order::create($data);
    echo "+";
}
echo "Ok\n";


echo "Seeding All Are Done !\n";