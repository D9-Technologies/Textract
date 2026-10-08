<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\Table;

interface TableFactoryInterface
{
    public function build(array $data): Table;
}
