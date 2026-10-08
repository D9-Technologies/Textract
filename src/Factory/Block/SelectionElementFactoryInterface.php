<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\SelectionElement;

interface SelectionElementFactoryInterface
{
    public function build(array $data): SelectionElement;
}
