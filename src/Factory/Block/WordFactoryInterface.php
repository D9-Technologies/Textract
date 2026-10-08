<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\Word;

interface WordFactoryInterface
{
    public function build(array $data): Word;
}
