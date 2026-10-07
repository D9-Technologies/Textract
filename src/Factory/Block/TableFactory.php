<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\Table;

class TableFactory extends AbstractBlockFactory implements TableFactoryInterface
{
    public function build(array $data): Table
    {
        return new Table(
            $data['Id'],
            $this->getGeometryFactory()->build($data['Geometry'])
        );
    }
}
