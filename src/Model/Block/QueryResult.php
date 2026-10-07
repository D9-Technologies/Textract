<?php

namespace D9\Textract\Model\Block;

use D9\Textract\Model\Geometry\Geometry;

class QueryResult extends AbstractBlock implements HasTextInterface
{
    private string $text;

    public function __construct(
        string $id,
        ?Geometry $geometry,
        string $text
    ) {
        parent::__construct($id, $geometry);
        $this->text = $text;
    }

    public function getBlockType(): BlockType
    {
        return BlockType::QUERY_RESULT;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}