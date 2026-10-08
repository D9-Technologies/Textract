<?php

namespace D9\Textract\Builder;

use D9\Textract\Model\Document;

interface DocumentBuilderInterface
{
    public function build(array $data): Document;
}
