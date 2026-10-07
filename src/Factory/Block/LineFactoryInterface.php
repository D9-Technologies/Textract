<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\Line;

interface LineFactoryInterface
{
    public function build(array $data): Line;
}
