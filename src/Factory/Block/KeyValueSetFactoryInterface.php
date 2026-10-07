<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\KeyValueSet;

interface KeyValueSetFactoryInterface
{
    public function build(array $data): KeyValueSet;
}
