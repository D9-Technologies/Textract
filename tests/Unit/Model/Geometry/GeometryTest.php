<?php

namespace D9\Textract\Tests\Unit\Model\Geometry;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use D9\Textract\Model\Geometry\BoundingBox;
use D9\Textract\Model\Geometry\Geometry;
use D9\Textract\Model\Geometry\Polygon;

/**
 * @covers \D9\Textract\Model\Geometry\Geometry
 */
class GeometryTest extends TestCase
{
    public function testGetDimensions()
    {
        $faker = Factory::create();

        $boundingBoxStub = $this->createStub(BoundingBox::class);
        $polygonStub = $this->createStub(Polygon::class);

        $geometry = new Geometry(
            $boundingBoxStub,
            $polygonStub,
        );

        $this->assertSame($boundingBoxStub, $geometry->getBoundingBox());
        $this->assertSame($polygonStub, $geometry->getPolygon());
    }
}
