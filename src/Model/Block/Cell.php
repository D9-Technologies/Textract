<?php

namespace D9\Textract\Model\Block;

use D9\Textract\Model\Geometry\Geometry;

class Cell extends AbstractBlock implements HasConfidenceInterface
{
    private float $confidence;
    private int $rowIndex;
    private int $columnIndex;
    private int $rowSpan;
    private int $columnSpan;

    public function __construct(
        string $id,
        Geometry $geometry,
        float $confidence,
        int $rowIndex,
        int $columnIndex,
        int $rowSpan,
        int $columnSpan
    ) {
        parent::__construct($id, $geometry);
        $this->confidence = $confidence;
        $this->rowIndex = $rowIndex;
        $this->columnIndex = $columnIndex;
        $this->rowSpan = $rowSpan;
        $this->columnSpan = $columnSpan;
    }

    public function getBlockType(): BlockType
    {
        return BlockType::CELL;
    }

    /**
     * @return float
     */
    public function getConfidence(): float
    {
        return $this->confidence;
    }

    /**
     * @return int
     */
    public function getRowIndex(): int
    {
        return $this->rowIndex;
    }

    /**
     * @return int
     */
    public function getColumnIndex(): int
    {
        return $this->columnIndex;
    }

    /**
     * @return int
     */
    public function getRowSpan(): int
    {
        return $this->rowSpan;
    }

    /**
     * @return int
     */
    public function getColumnSpan(): int
    {
        return $this->columnSpan;
    }
}
