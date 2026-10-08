<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\Query;

interface QueryFactoryInterface
{
    public function build(array $data): Query;
}
