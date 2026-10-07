<?php

namespace D9\Textract\Tests\Unit\Factory\Block;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use D9\Textract\Factory\Block\CellFactory;
use D9\Textract\Factory\Geometry\BoundingBoxFactoryInterface;
use D9\Textract\Factory\Geometry\GeometryFactory;
use D9\Textract\Factory\Geometry\GeometryFactoryInterface;
use D9\Textract\Factory\Geometry\PointFactory;
use D9\Textract\Factory\Geometry\PointFactoryInterface;
use D9\Textract\Factory\Geometry\PolygonFactory;
use D9\Textract\Factory\Geometry\PolygonFactoryInterface;
use D9\Textract\Model\Geometry\BoundingBox;
use D9\Textract\Model\Geometry\Geometry;
use D9\Textract\Model\Geometry\Point;
use D9\Textract\Model\Geometry\Polygon;
use D9\Textract\Tests\AbstractBaseTest;

/**
 * @covers \D9\Textract\Factory\Block\CellFactory
 * @covers \D9\Textract\Factory\Block\AbstractBlockFactory
 */
class CellFactoryTest extends AbstractBaseTest
{
    public function testBuild()
    {
        $faker = Factory::create();

        $geometryData = $this->createTestGeometryData();

        $geometryStub = $this->createStub(Geometry::class);

        $geometryFactoryMock = $this->createMock(GeometryFactoryInterface::class);
        $geometryFactoryMock->expects($this->once())
            ->method('build')
            ->with($geometryData)
            ->willReturn($geometryStub);

        $id = $faker->uuid();
        $confidence = $faker->randomFloat();
        $rowIndex = $faker->randomNumber();
        $columnIndex = $faker->randomNumber();
        $rowSpan = $faker->randomNumber();
        $columnSpan = $faker->randomNumber();

        $blockData =
            [
                'Id' => $id,
                'Geometry' => $geometryData,
                'Confidence' => $confidence,
                'RowIndex' => $rowIndex,
                'ColumnIndex' => $columnIndex,
                'RowSpan' => $rowSpan,
                'ColumnSpan' => $columnSpan,
            ];


        $factory = new CellFactory($geometryFactoryMock);

        $block = $factory->build($blockData);

        $this->assertEquals($id, $block->getId());
        $this->assertSame($geometryStub, $block->getGeometry());
        $this->assertEquals($confidence, $block->getConfidence());
        $this->assertEquals($rowIndex, $block->getRowIndex());
        $this->assertEquals($columnIndex, $block->getColumnIndex());
        $this->assertEquals($rowSpan, $block->getRowSpan());
        $this->assertEquals($columnSpan, $block->getColumnSpan());
    }
}
