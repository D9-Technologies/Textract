<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\Signature;

interface SignatureFactoryInterface
{
    public function build(array $data): Signature;
}
