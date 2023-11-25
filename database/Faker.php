<?php
namespace Faker;
use \Faker\Factory;
use \Faker\Generator;

abstract class Faker {
    protected static string $locale = 'en_US';

    protected static function create_faker($locale = null): Generator {
        return Factory::create($locale ?: self::$locale ?: Factory::DEFAULT_LOCALE);
    }

    /**
     * Generate fake data
     *
     * @return array
     */
    abstract public static function generate(): array;
}