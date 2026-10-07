<?php

namespace D9\Textract\Factory\Geometry;

use D9\Textract\Model\Geometry\Polygon;

interface PolygonFactoryInterface
{
    public function build(array $data): Polygon;
}
