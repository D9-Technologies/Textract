<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\TableFooter;

interface TableFooterFactoryInterface
{
    public function build(array $data): TableFooter;
}