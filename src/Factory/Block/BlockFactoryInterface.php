<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\BlockInterface;

interface BlockFactoryInterface
{
    public function build(array $data): BlockInterface;
}
