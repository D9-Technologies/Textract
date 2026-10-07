<?php

namespace D9\Textract\Model\Block;

class Signature extends AbstractBlock
{
    public function getBlockType(): BlockType
    {
        return BlockType::SIGNATURE;
    }
}
