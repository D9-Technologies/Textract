<?php

namespace D9\Textract\Tests\Unit\Model\Geometry;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use D9\Textract\Model\Geometry\Point;
use D9\Textract\Model\Geometry\Polygon;

/**
 * @covers \D9\Textract\Model\Geometry\Polygon
 */
class PolygonTest extends TestCase
{
    public function testGetCoordinates()
    {
        $faker = Factory::create();

        $pointStub1 = $this->createStub(Point::class);
        $pointStub2 = $this->createStub(Point::class);

        $point = new Polygon(
            [$pointStub1, $pointStub2]
        );

        $this->assertEquals([$pointStub1, $pointStub2], $point->getPoints());
        $this->assertSame($pointStub1, $point->getPoints()[0]);
        $this->assertSame($pointStub2, $point->getPoints()[1]);
    }
}
