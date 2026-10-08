<?php

namespace D9\Textract\Factory\Geometry;

use D9\Textract\Model\Geometry\Point;

interface PointFactoryInterface
{
    public function build(array $data): Point;
}
