<?php

namespace D9\Textract\Model\Block;

class Table extends AbstractBlock
{
    public function getBlockType(): BlockType
    {
        return BlockType::TABLE;
    }
}
