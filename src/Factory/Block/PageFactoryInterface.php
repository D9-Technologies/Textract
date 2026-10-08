<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\Page;

interface PageFactoryInterface
{
    public function build(array $data): Page;
}
