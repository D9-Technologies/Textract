<?php

namespace D9\Textract\Tests\Unit\Factory\Geometry;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use D9\Textract\Factory\Geometry\PointFactory;
use D9\Textract\Factory\Geometry\PointFactoryInterface;
use D9\Textract\Factory\Geometry\PolygonFactory;
use D9\Textract\Model\Geometry\Point;

/**
 * @covers \D9\Textract\Factory\Geometry\PolygonFactory
 */
class PolygonFactoryTest extends TestCase
{
    public function testBuild()
    {
        $faker = Factory::create();

        $x = $faker->randomFloat();
        $y = $faker->randomFloat();

        $pointData = [];
        $points = [];

        for ($i = 0; $i <= $faker->randomNumber() + 1; ++$i) {
            $x = $faker->randomFloat();
            $y = $faker->randomFloat();

            $pointData[] = ['X' => $x, 'Y' => $y];
            $points[] = new Point($x, $y);
        }

        $pointFactoryMock = $this->createMock(PointFactoryInterface::class);
        $pointFactoryMock->method('build')
            ->withConsecutive(
                ...array_map(
                    function ($pointDataItem) {
                        return [$pointDataItem];
                    },
                    $pointData
                )
            )
            ->willReturnOnConsecutiveCalls(
                ...$points
            );

        $factory = new PolygonFactory($pointFactoryMock);

        $polygon = $factory->build($pointData);

        $this->assertEquals($points, $polygon->getPoints());
    }
}
