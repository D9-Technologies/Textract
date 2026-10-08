<?php

namespace D9\Textract\Tests\Unit\Factory\Block;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use D9\Textract\Factory\Block\CellFactory;
use D9\Textract\Factory\Block\KeyValueSetFactory;
use D9\Textract\Factory\Block\LineFactory;
use D9\Textract\Factory\Block\MergedCellFactory;
use D9\Textract\Factory\Block\PageFactory;
use D9\Textract\Factory\Block\QueryFactory;
use D9\Textract\Factory\Block\QueryResultFactory;
use D9\Textract\Factory\Geometry\BoundingBoxFactoryInterface;
use D9\Textract\Factory\Geometry\GeometryFactory;
use D9\Textract\Factory\Geometry\GeometryFactoryInterface;
use D9\Textract\Factory\Geometry\PointFactory;
use D9\Textract\Factory\Geometry\PointFactoryInterface;
use D9\Textract\Factory\Geometry\PolygonFactory;
use D9\Textract\Factory\Geometry\PolygonFactoryInterface;
use D9\Textract\Model\Block\EntityType;
use D9\Textract\Model\Geometry\BoundingBox;
use D9\Textract\Model\Geometry\Geometry;
use D9\Textract\Model\Geometry\Point;
use D9\Textract\Model\Geometry\Polygon;
use D9\Textract\Tests\AbstractTestCase;

/**
 * @covers \D9\Textract\Factory\Block\QueryResultFactory
 * @covers \D9\Textract\Factory\Block\AbstractBlockFactory
 */
class QueryResultFactoryTest extends AbstractTestCase
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
        $text = $faker->word();

        $blockData =
            [
                'Id' => $id,
                'Geometry' => $geometryData,
                'Text' => $text,
            ];


        $factory = new QueryResultFactory($geometryFactoryMock);

        $block = $factory->build($blockData);

        $this->assertEquals($id, $block->getId());
        $this->assertSame($geometryStub, $block->getGeometry());
        $this->assertSame($text, $block->getText());
    }
}
