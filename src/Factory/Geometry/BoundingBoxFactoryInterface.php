<?php

namespace D9\Textract\Factory\Geometry;

use D9\Textract\Model\Geometry\BoundingBox;

interface BoundingBoxFactoryInterface
{
    public function build(array $data): BoundingBox;
}
