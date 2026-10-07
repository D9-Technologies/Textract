<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\MergedCell;

class MergedCellFactory extends AbstractBlockFactory implements MergedCellFactoryInterface
{
    public function build(array $data): MergedCell
    {
        return new MergedCell(
            $data['Id'],
            $this->getGeometryFactory()->build($data['Geometry'])
        );
    }
}
