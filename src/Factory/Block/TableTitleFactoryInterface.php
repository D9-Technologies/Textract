<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\TableTitle;

interface TableTitleFactoryInterface
{
    public function build(array $data): TableTitle;
}