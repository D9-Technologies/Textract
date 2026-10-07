<?php

namespace D9\Textract\Tests\Unit\Model\Block;

use PHPUnit\Framework\TestCase;
use D9\Textract\Model\Block\BlockInterface;
use D9\Textract\Model\Block\RelationshipType;

abstract class AbstractBlockTest extends TestCase
{
    public function relationshipProvider(): array
    {
        return
        [
            [RelationshipType::TITLE, $this->createStub(BlockInterface::class)],
            [RelationshipType::CHILD, $this->createStub(BlockInterface::class)],
            [RelationshipType::VALUE, $this->createStub(BlockInterface::class)],
            [RelationshipType::MERGED_CELL, $this->createStub(BlockInterface::class)],
            [RelationshipType::COMPLEX_FEATURES, $this->createStub(BlockInterface::class)],
            [RelationshipType::ANSWER, $this->createStub(BlockInterface::class)],
        ];
    }
}
