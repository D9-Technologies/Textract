<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\TableFooter;

class TableFooterFactory extends AbstractBlockFactory implements TableFooterFactoryInterface
{

    public function build(array $data): TableFooter
    {
        return new TableFooter($data['Id'], $this->getGeometryFactory()->build($data['Geometry']),);
    }
}