<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\MergedCell;

interface MergedCellFactoryInterface
{
    public function build(array $data): MergedCell;
}
