<?php

namespace D9\Textract\Tests\Unit\Builder;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use D9\Textract\Builder\BlockBuilder;
use D9\Textract\Factory\Block\BlockFactoryInterface;
use D9\Textract\Factory\Block\CellFactoryInterface;
use D9\Textract\Factory\Geometry\GeometryFactoryInterface;
use D9\Textract\Model\Block\BlockInterface;
use D9\Textract\Model\Block\BlockType;
use D9\Textract\Model\Block\Cell;
use D9\Textract\Model\Block\EntityType;
use D9\Textract\Model\Block\KeyValueSet;
use D9\Textract\Model\Block\Line;
use D9\Textract\Model\Block\MergedCell;
use D9\Textract\Model\Block\Page;
use D9\Textract\Model\Block\Query;
use D9\Textract\Model\Block\QueryResult;
use D9\Textract\Model\Block\SelectionElement;
use D9\Textract\Model\Block\SelectionStatus;
use D9\Textract\Model\Block\Signature;
use D9\Textract\Model\Block\Table;
use D9\Textract\Model\Block\Word;
use D9\Textract\Model\Geometry\Geometry;
use D9\Textract\Tests\AbstractBaseTest;

/**
 * @covers \D9\Textract\Builder\BlockBuilder
 */
class BlockBuilderTest extends AbstractBaseTest
{
    /**
     * @dataProvider blockBuilderProvider
     */
    public function testBuildWithInjectedBlockFactory(
        BlockType $blockType,
        string $expectedBlockClass,
        array $blockData
    ) {
        $geometryFactoryStub = $this->createStub(GeometryFactoryInterface::class);

        $blockStub = $this->createStub($expectedBlockClass);

        $blockFactoryMock = $this->createMock(BlockFactoryInterface::class);
        $blockFactoryMock->expects($this->once())
            ->method('build')
            ->with($blockData)
            ->willReturn($blockStub);

        $builder = new BlockBuilder($geometryFactoryStub);

        $builder->setBlockFactory($blockFactoryMock, $blockType);

        $block = $builder->build($blockData);

        $this->assertSame($blockStub, $block);
    }


    /**
     * @dataProvider blockBuilderProvider
     */
    public function testBuild(BlockType $blockType, string $expectedBlockClass, array $blockData)
    {
        $geometryStub = $this->createStub(Geometry::class);

        $geometryFactoryMock = $this->createMock(GeometryFactoryInterface::class);
        $geometryFactoryMock->expects($this->once())
            ->method('build')
            ->with($blockData['Geometry'])
            ->willReturn($geometryStub);

        $blockStub = $this->createStub($expectedBlockClass);

        $builder = new BlockBuilder($geometryFactoryMock);

        $block = $builder->build($blockData);

        $this->assertInstanceOf($expectedBlockClass, $block);
    }

    public function blockBuilderProvider(): array
    {
        $faker = Factory::create();

        return [
            [
                BlockType::PAGE,
                Page::class,
                [
                    'BlockType' => BlockType::PAGE->value,
                    'Id' => $faker->uuid(),
                    'Geometry' => $this->createTestGeometryData(),
                ]
            ],
            [
                BlockType::LINE,
                Line::class,
                [
                    'BlockType' => BlockType::LINE->value,
                    'Id' => $faker->uuid(),
                    'Geometry' => $this->createTestGeometryData(),
                    'Confidence' => $faker->randomFloat(),
                    'Text' => $faker->sentence(),
                ]
            ],
            [
                BlockType::WORD,
                Word::class,
                [
                    'BlockType' => BlockType::WORD->value,
                    'Id' => $faker->uuid(),
                    'Geometry' => $this->createTestGeometryData(),
                    'Confidence' => $faker->randomFloat(),
                    'Text' => $faker->word(),
                ]
            ],
            [
                BlockType::TABLE,
                Table::class,
                [
                    'BlockType' => BlockType::TABLE->value,
                    'Id' => $faker->uuid(),
                    'Geometry' => $this->createTestGeometryData(),
                ]
            ],
            [
                BlockType::CELL,
                Cell::class,
                [
                    'BlockType' => BlockType::CELL->value,
                    'Id' => $faker->uuid(),
                    'Geometry' => $this->createTestGeometryData(),
                    'Confidence' => $faker->randomFloat(),
                    'RowIndex' => $faker->randomNumber(),
                    'ColumnIndex' => $faker->randomNumber(),
                    'RowSpan' => $faker->randomNumber(),
                    'ColumnSpan' => $faker->randomNumber(),
                ]
            ],
            [
                BlockType::KEY_VALUE_SET,
                KeyValueSet::class,
                [
                    'BlockType' => BlockType::KEY_VALUE_SET->value,
                    'Id' => $faker->uuid(),
                    'Geometry' => $this->createTestGeometryData(),
                    'Confidence' => $faker->randomFloat(),
                    'EntityTypes' => [EntityType::KEY->value]
                ]
            ],
            [
                BlockType::MERGED_CELL,
                MergedCell::class,
                [
                    'BlockType' => BlockType::MERGED_CELL->value,
                    'Id' => $faker->uuid(),
                    'Geometry' => $this->createTestGeometryData(),
                ]
            ],
            [
                BlockType::SELECTION_ELEMENT,
                SelectionElement::class,
                [
                    'BlockType' => BlockType::SELECTION_ELEMENT->value,
                    'Id' => $faker->uuid(),
                    'Geometry' => $this->createTestGeometryData(),
                    'Confidence' => $faker->randomFloat(),
                    'SelectionStatus' => SelectionStatus::SELECTED->value
                ]
            ],
            [
                BlockType::SIGNATURE,
                Signature::class,
                [
                    'BlockType' => BlockType::SIGNATURE->value,
                    'Id' => $faker->uuid(),
                    'Geometry' => $this->createTestGeometryData(),
                ]
            ],
            [
                BlockType::QUERY,
                Query::class,
                [
                    'BlockType' => BlockType::QUERY->value,
                    'Id' => $faker->uuid(),
                    'Geometry' => $this->createTestGeometryData(),
                    'Query' => [
                        'Alias' => $faker->word(),
                        'Text' => $faker->sentence()
                    ],
                ]
            ],
            [
                BlockType::QUERY_RESULT,
                QueryResult::class,
                [
                    'BlockType' => BlockType::QUERY_RESULT->value,
                    'Id' => $faker->uuid(),
                    'Geometry' => $this->createTestGeometryData(),
                    'Text' => $faker->word(),
                ]
            ],
        ];
    }
}
