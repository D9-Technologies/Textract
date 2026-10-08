<?php

namespace D9\Textract\Model\Block;

use D9\Textract\Model\Geometry\Geometry;

class SelectionElement extends AbstractBlock implements HasConfidenceInterface, HasValue
{
    private float $confidence;
    private SelectionStatus $selectionStatus;

    public function __construct(
        string $id,
        Geometry $geometry,
        float $confidence,
        SelectionStatus $selectionStatus
    ) {
        parent::__construct($id, $geometry);
        $this->confidence = $confidence;
        $this->selectionStatus = $selectionStatus;
    }

    public function getBlockType(): BlockType
    {
        return BlockType::SELECTION_ELEMENT;
    }

    /**
     * @return float
     */
    public function getConfidence(): float
    {
        return $this->confidence;
    }

    /**
     * @return SelectionStatus
     */
    public function getSelectionStatus(): SelectionStatus
    {
        return $this->selectionStatus;
    }

    public function isSelected(): bool
    {
        return $this->selectionStatus === SelectionStatus::SELECTED;
    }

    public function getValue(): bool
    {
        return $this->isSelected();
    }
}
