<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\QueryResult;

interface QueryResultFactoryInterface
{
    public function build(array $data): QueryResult;
}
