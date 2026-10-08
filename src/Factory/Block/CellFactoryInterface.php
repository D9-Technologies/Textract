<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\Cell;

interface CellFactoryInterface
{
    public function build(array $data): Cell;
}
