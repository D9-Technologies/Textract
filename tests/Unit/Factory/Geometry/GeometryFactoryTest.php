<?php

namespace D9\Textract\Tests\Unit\Factory\Geometry;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use D9\Textract\Factory\Geometry\BoundingBoxFactoryInterface;
use D9\Textract\Factory\Geometry\GeometryFactory;
use D9\Textract\Factory\Geometry\PointFactory;
use D9\Textract\Factory\Geometry\PointFactoryInterface;
use D9\Textract\Factory\Geometry\PolygonFactory;
use D9\Textract\Factory\Geometry\PolygonFactoryInterface;
use D9\Textract\Model\Geometry\BoundingBox;
use D9\Textract\Model\Geometry\Point;
use D9\Textract\Model\Geometry\Polygon;

/**
 * @covers \D9\Textract\Factory\Geometry\GeometryFactory
 */
class GeometryFactoryTest extends TestCase
{
    public function testBuild()
    {
        $faker = Factory::create();

        $boundingBoxData = [
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

        $geometryData = [
            'BoundingBox' => $boundingBoxData,
            'Polygon' => $polygonData
        ];

        $boundingBox = new BoundingBox(
            $faker->randomFloat(),
            $faker->randomFloat(),
            $faker->randomFloat(),
            $faker->randomFloat()
        );


        $polygon = new Polygon(
            []
        );

        $boundingBoxFactoryMock = $this->createMock(BoundingBoxFactoryInterface::class);
        $boundingBoxFactoryMock->expects($this->once())
            ->method('build')
            ->with($boundingBoxData)
            ->willReturn($boundingBox);

        $polygonFactoryMock = $this->createMock(PolygonFactoryInterface::class);
        $polygonFactoryMock->expects($this->once())
            ->method('build')
            ->with($polygonData)
            ->willReturn($polygon);


        $factory = new GeometryFactory($boundingBoxFactoryMock, $polygonFactoryMock);

        $geometry = $factory->build($geometryData);

        $this->assertSame($boundingBox, $geometry->getBoundingBox());
        $this->assertSame($polygon, $geometry->getPolygon());
    }
}
