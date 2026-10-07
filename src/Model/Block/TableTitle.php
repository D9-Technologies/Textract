<?php

namespace D9\Textract\Model\Block;

use D9\Textract\Model\Block;

class TableTitle extends Block\AbstractBlock
{

    public function getBlockType(): BlockType
    {
        return BlockType::TABLE_TITLE;
    }
}