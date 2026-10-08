<?php

namespace D9\Textract\Factory\Geometry;

use D9\Textract\Model\Geometry\BoundingBox;

class BoundingBoxFactory implements BoundingBoxFactoryInterface
{
    public function build(array $data): BoundingBox
    {
        return new BoundingBox(
            (float)$data['Width'],
            (float)$data['Height'],
            (float)$data['Left'],
            (float)$data['Top'],
        );
    }
}
