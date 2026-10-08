<?php

namespace D9\Textract\Tests\Integration\Builder;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use D9\Textract\Builder\BlockBuilderInterface;
use D9\Textract\Builder\DocumentBuilder;
use D9\Textract\Model\Block\BlockType;
use D9\Textract\Model\Block\Page;
use D9\Textract\Model\Block\RelationshipType;
use D9\Textract\Model\Block\Word;
use D9\Textract\Model\Document;
use D9\Textract\Model\Geometry\BoundingBox;
use D9\Textract\Model\Geometry\Geometry;
use D9\Textract\Model\Geometry\Point;
use D9\Textract\Model\Geometry\Polygon;

/**
 * @covers \D9\Textract\Builder\DocumentBuilder
 */
class DocumentBuilderTest extends TestCase
{
    public function testBuild()
    {
        $faker = Factory::create();

        $version = $faker->uuid();
        $pageId = $faker->uuid();
        $wordId = $faker->uuid();

        $pageBlockData = [
            'BlockType' => BlockType::PAGE->value,
            'Id' => $pageId,
            'Relationships' =>
                [
                    [
                        'Type' => RelationshipType::MERGED_CELL->value,
                        'Ids' => [
                            $wordId
                        ]
                    ],
                    [
                        'Type' => RelationshipType::VALUE->value,
                        'Ids' => [
                            $wordId
                        ]
                    ],
                    [
                        'Type' => RelationshipType::TITLE->value,
                        'Ids' => [
                            $wordId
                        ]
                    ],
                    [
                        'Type' => RelationshipType::CHILD->value,
                        'Ids' => [
                            $wordId
                        ]
                    ],
                    [
                        'Type' => RelationshipType::ANSWER->value,
                        'Ids' => [
                            $wordId
                        ]
                    ],
                    [
                        'Type' => RelationshipType::COMPLEX_FEATURES->value,
                        'Ids' => [
                            $wordId
                        ]
                    ]
                ],
        ];

        $wordBlockData = [
            [
                'BlockType' => BlockType::WORD->value,
                'Id' => $wordId,
                'Text' => $faker->word()
            ]
        ];

        $pageMock = $this->createMock(Page::class);
        $pageMock->method('getId')->willReturn($pageId);

        $wordMock = $this->createMock(Word::class);
        $wordMock->method('getId')->willReturn($wordId);

        $expectedRelationshipTypes = [
            RelationshipType::MERGED_CELL,
            RelationshipType::VALUE,
            RelationshipType::TITLE,
            RelationshipType::CHILD,
            RelationshipType::ANSWER,
            RelationshipType::COMPLEX_FEATURES,
        ];

        $expectedChildren = $expectedRelationshipTypes;
        $pageMock->expects($this->exactly(6))
            ->method('addChild')
            ->willReturnCallback(function (RelationshipType $relationshipType, $block) use (&$expectedChildren, $wordMock) {
                $this->assertSame(array_shift($expectedChildren), $relationshipType);
                $this->assertSame($wordMock, $block);
            });

        $expectedParents = $expectedRelationshipTypes;
        $wordMock->expects($this->exactly(6))
            ->method('addParent')
            ->willReturnCallback(function (RelationshipType $relationshipType, $block) use (&$expectedParents, $pageMock) {
                $this->assertSame(array_shift($expectedParents), $relationshipType);
                $this->assertSame($pageMock, $block);
            });

        $blockBuilderMock = $this->createMock(BlockBuilderInterface::class);

        $expectedBuilds = [
            [$pageBlockData, $pageMock],
            [$wordBlockData, $wordMock],
        ];
        $blockBuilderMock->expects($this->exactly(2))
            ->method('build')
            ->willReturnCallback(function (array $blockData) use (&$expectedBuilds) {
                [$expectedBlockData, $block] = array_shift($expectedBuilds);
                $this->assertSame($expectedBlockData, $blockData);

                return $block;
            });

        $dataArray = [
            'AnalyzeDocumentModelVersion' => $version,
            'Blocks' => [
                $pageBlockData,
                $wordBlockData
            ]
        ];


        $builder = new DocumentBuilder($blockBuilderMock);

        $document = $builder->build($dataArray);

        $this->assertSame($pageMock, $document->getPages()[0]);
    }

    public function testBuildFromFixture()
    {
        $fixture = __DIR__ . '/../../Fixtures/w2.json';

        if (!file_exists($fixture)) {
            $this->markTestSkipped('Fixtures are not committed; add tests/Fixtures/w2.json to run this test.');
        }

        $data = file_get_contents($fixture);
        $dataArray = json_decode($data, true);

        $builder = new DocumentBuilder();

        $document = $builder->build($dataArray);

        $this->assertInstanceOf(Document::class, $document);

        $this->assertCount(1, $document->getPages());

        $page = $document->getPages()[0];

        $this->assertEquals('f93bbd44-0040-413e-a988-2a99cd1039dc', $page->getId());

        $this->assertEquals(
            new Geometry(
                new BoundingBox(
                    0.9997605085372925,
                    1.0,
                    0.00023950317699927837,
                    0.0
                ),
                new Polygon(
                    [
                        new Point(0.00046867222408764064, 0),
                        new Point(1.0, 8.142334451122224E-8),
                        new Point(1.0, 1.0),
                        new Point(0.00023950317699927837, 1.0),
                    ]
                )
            ),
            $page->getGeometry()
        );

        $this->assertCount(0, $page->getParents(RelationshipType::COMPLEX_FEATURES));
        $this->assertCount(0, $page->getParents(RelationshipType::VALUE));
        $this->assertCount(0, $page->getParents(RelationshipType::MERGED_CELL));
        $this->assertCount(0, $page->getParents(RelationshipType::ANSWER));
        $this->assertCount(0, $page->getParents(RelationshipType::CHILD));
        $this->assertCount(0, $page->getParents(RelationshipType::TITLE));

        $this->assertCount(0, $page->getChildren(RelationshipType::COMPLEX_FEATURES));
        $this->assertCount(0, $page->getChildren(RelationshipType::VALUE));
        $this->assertCount(0, $page->getChildren(RelationshipType::MERGED_CELL));
        $this->assertCount(0, $page->getChildren(RelationshipType::ANSWER));
        $this->assertCount(91, $page->getChildren(RelationshipType::CHILD));
        $this->assertCount(0, $page->getChildren(RelationshipType::TITLE));


        $this->assertCount(22, $page->getKeyValueSets());
    }
}
