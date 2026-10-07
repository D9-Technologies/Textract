<?php

namespace D9\Textract\Model\Block;

class MergedCell extends AbstractBlock
{
    public function getBlockType(): BlockType
    {
        return BlockType::MERGED_CELL;
    }
}
