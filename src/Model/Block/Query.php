<?php

namespace D9\Textract\Model\Block;

use D9\Textract\Model\Geometry\Geometry;

class Query extends AbstractBlock implements HasTextInterface
{
    private string $alias;
    private string $text;

    public function __construct(
        string $id,
        ?Geometry $geometry,
        string $alias,
        string $text
    ) {
        parent::__construct($id, $geometry);
        $this->alias = $alias;
        $this->text = $text;
    }

    public function getBlockType(): BlockType
    {
        return BlockType::QUERY;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}