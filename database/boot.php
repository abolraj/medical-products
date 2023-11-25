<?php
//Requirements
// Root directory
define('DIR_ROOT', __DIR__.'/..');

// Project Dependencies
require_once(DIR_ROOT . '/app/require.php');
require_once(DIR_DATABASE . '/Faker.php');
auto_require_scripts(DIR_DATABASE, ['boot','seeder','Faker']);

use DB\DB;

// tables :
// 1 - users : handle users
// 2 - products : handle medical products
// 3 - offers : handle offers
// 4 - orders : handle user's orders

// Reset the database
if(in_array('reset', $argv)){
    echo "Resetting Database ...";
    DB::query("SHOW TABLES");
    $rows = DB::fetch_all(false);
    foreach($rows as $row)
        DB::query("DROP TABLE ".$row[0]);
    echo "Ok\n";
}

// users
$q = 'CREATE TABLE `users` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(255) NOT NULL,
    `password` VARCHAR(32) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME
);';
DB::query($q);

// products
$q = 'CREATE TABLE `products` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `price` INT NOT NULL,
    `quantity` INT NOT NULL,
    `image` VARCHAR(255) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME
);';
DB::query($q);

// offers
$q = 'CREATE TABLE `offers` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `product_id` INT NOT NULL,
    `value` DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id),
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME
);';
DB::query($q);

// orders
$q = 'CREATE TABLE `orders` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `quantity` INT NOT NULL,
    `price` INT NOT NULL,
    `total_price` INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME
);';
DB::query($q);

if(in_array('seed', $argv)){
    require_once DIR_DATABASE . '/seeder.php';
}