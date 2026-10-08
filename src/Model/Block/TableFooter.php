<?php

namespace D9\Textract\Model\Block;

class TableFooter extends AbstractBlock
{

    public function getBlockType(): BlockType
    {
        return Blocktype::TABLE_FOOTER;
    }
}