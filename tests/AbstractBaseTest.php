<?php

namespace D9\Textract\Tests;

use Faker\Factory;
use PHPUnit\Framework\TestCase;

abstract class AbstractBaseTest extends TestCase
{
    protected function createTestGeometryData(): array
    {
        $faker = Factory::create();

        $geometryData = [
            'Width' => $faker->randomFloat(),
            'Height' => $faker->randomFloat(),
            'Left' => $faker->randomFloat(),
            'Top' => $faker->randomFloat()
        ];

        $polygonData = [
            [
                'X' => $faker->randomFloat(),
                'Y' => $faker->randomFloat(),
            ],
            [
                'X' => $faker->randomFloat(),
                'Y' => $faker->randomFloat(),
            ],
        ];

        return [
            'BoundingBox' => $geometryData,
            'Polygon' => $polygonData
        ];
    }
}
