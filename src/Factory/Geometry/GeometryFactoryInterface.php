<?php

namespace D9\Textract\Factory\Geometry;

use D9\Textract\Model\Geometry\Geometry;

interface GeometryFactoryInterface
{
    public function build(array $data): Geometry;
}
