<?php

namespace D9\Textract\Tests\Unit\Factory\Block;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use D9\Textract\Factory\Block\CellFactory;
use D9\Textract\Factory\Block\KeyValueSetFactory;
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
 * @covers \D9\Textract\Factory\Block\KeyValueSetFactory
 * @covers \D9\Textract\Factory\Block\AbstractBlockFactory
 */
class KeyValueSetFactoryTest extends AbstractTestCase
{
    /**
     * @param EntityType $entityType
     * @return void
     * @dataProvider keyValueSetProvider
     */
    public function testBuild(EntityType $entityType)
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

        $blockData =
            [
                'Id' => $id,
                'Geometry' => $geometryData,
                'Confidence' => $confidence,
                'EntityTypes' => [$entityType->value],
            ];


        $factory = new KeyValueSetFactory($geometryFactoryMock);

        $block = $factory->build($blockData);

        $this->assertEquals($id, $block->getId());
        $this->assertSame($geometryStub, $block->getGeometry());
        $this->assertEquals($confidence, $block->getConfidence());
        $this->assertEquals($entityType, $block->getEntityType());
    }
    
    public static function keyValueSetProvider(): array
    {
        return [
            [EntityType::KEY],
            [EntityType::VALUE],
            [EntityType::COLUMN_HEADER],
        ];
    }
}
