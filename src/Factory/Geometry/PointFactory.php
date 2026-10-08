<?php

namespace D9\Textract\Factory\Geometry;

use D9\Textract\Model\Geometry\Point;

class PointFactory implements PointFactoryInterface
{
    public function build(array $data): Point
    {
        return new Point(
            (float)$data['X'],
            (float)$data['Y'],
        );
    }
}
