<?php

namespace D9\Textract\Tests\Unit\Factory\Block;

use Faker\Factory;
use D9\Textract\Factory\Block\MergedCellFactory;
use D9\Textract\Factory\Geometry\GeometryFactoryInterface;
use D9\Textract\Model\Geometry\Geometry;
use D9\Textract\Tests\AbstractBaseTest;

/**
 * @covers \D9\Textract\Factory\Block\MergedCellFactory
 * @covers \D9\Textract\Factory\Block\AbstractBlockFactory
 */
class MergedCellFactoryTest extends AbstractBaseTest
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
        $blockData =
            [
                'Id' => $id,
                'Geometry' => $geometryData,
            ];


        $factory = new MergedCellFactory($geometryFactoryMock);

        $block = $factory->build($blockData);

        $this->assertEquals($id, $block->getId());
        $this->assertSame($geometryStub, $block->getGeometry());
    }
}
