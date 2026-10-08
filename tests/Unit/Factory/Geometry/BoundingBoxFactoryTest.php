<?php

namespace D9\Textract\Tests\Unit\Factory\Geometry;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use D9\Textract\Factory\Geometry\BoundingBoxFactory;

/**
 * @covers \D9\Textract\Factory\Geometry\BoundingBoxFactory
 */
class BoundingBoxFactoryTest extends TestCase
{
    public function testBuild()
    {
        $faker = Factory::create();

        $width = $faker->randomFloat();
        $height = $faker->randomFloat();
        $left = $faker->randomFloat();
        $top = $faker->randomFloat();

        $factory = new BoundingBoxFactory();

        $boundingBox = $factory->build(
            [
                'Width' => $width,
                'Height' => $height,
                'Left' => $left,
                'Top' => $top
            ]
        );

        $this->assertEquals($width, $boundingBox->getWidth());
        $this->assertEquals($height, $boundingBox->getHeight());
        $this->assertEquals($left, $boundingBox->getLeft());
        $this->assertEquals($top, $boundingBox->getTop());
    }
}
