<?php

namespace D9\Textract\Model\Block;

use D9\Textract\Model\Geometry\Geometry;

class Line extends AbstractBlock implements HasTextInterface, HasConfidenceInterface, HasValue
{
    private float $confidence;
    private string $text;

    public function __construct(
        string $id,
        Geometry $geometry,
        float $confidence,
        string $text
    ) {
        parent::__construct($id, $geometry);
        $this->confidence = $confidence;
        $this->text = $text;
    }

    public function getBlockType(): BlockType
    {
        return BlockType::LINE;
    }

    /**
     * @return float
     */
    public function getConfidence(): float
    {
        return $this->confidence;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    public function getValue(): string
    {
        return $this->getText();
    }
}
