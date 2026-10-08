<?php

namespace D9\Textract\Tests\Unit\Model\Block;

use PHPUnit\Framework\TestCase;
use D9\Textract\Model\Block\RelationshipType;

abstract class AbstractBlockTestCase extends TestCase
{
    public static function relationshipProvider(): array
    {
        return
        [
            [RelationshipType::TITLE],
            [RelationshipType::CHILD],
            [RelationshipType::VALUE],
            [RelationshipType::MERGED_CELL],
            [RelationshipType::COMPLEX_FEATURES],
            [RelationshipType::ANSWER],
        ];
    }
}
