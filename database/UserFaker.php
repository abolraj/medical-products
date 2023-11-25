<?php
namespace DB\Faker;

class UserFaker extends Faker {
    public static function generate(): array
    {
        $faker = static::create_faker();
        return [
            'username' => $faker->userName(),
            'password' => md5('123456'),
            'phone' => $faker->e164PhoneNumber(),
        ];
    }
}