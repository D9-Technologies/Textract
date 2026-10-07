<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\Line;

class LineFactory extends AbstractBlockFactory implements LineFactoryInterface
{
    public function build(array $data): Line
    {
        return new Line(
            $data['Id'],
            $this->getGeometryFactory()->build($data['Geometry']),
            (float)$data['Confidence'],
            $data['Text'],
        );
    }
}
