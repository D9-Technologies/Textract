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

        $pageMock->expects($this->exactly(6))
            ->method('addChild')
            ->withConsecutive(
                [RelationshipType::MERGED_CELL, $wordMock],
                [RelationshipType::VALUE, $wordMock],
                [RelationshipType::TITLE, $wordMock],
                [RelationshipType::CHILD, $wordMock],
                [RelationshipType::ANSWER, $wordMock],
                [RelationshipType::COMPLEX_FEATURES, $wordMock],
            );

        $wordMock->expects($this->exactly(6))
            ->method('addParent')
            ->withConsecutive(
                [RelationshipType::MERGED_CELL, $pageMock],
                [RelationshipType::VALUE, $pageMock],
                [RelationshipType::TITLE, $pageMock],
                [RelationshipType::CHILD, $pageMock],
                [RelationshipType::ANSWER, $pageMock],
                [RelationshipType::COMPLEX_FEATURES, $pageMock],
            );

        $blockBuilderMock = $this->createMock(BlockBuilderInterface::class);

        $blockBuilderMock->expects($this->exactly(2))
            ->method('build')
            ->withConsecutive([$pageBlockData], [$wordBlockData])
            ->willReturnOnConsecutiveCalls(
                $pageMock,
                $wordMock
            );

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
        $data = file_get_contents(__DIR__ . '/../../Fixtures/w2.json');
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
