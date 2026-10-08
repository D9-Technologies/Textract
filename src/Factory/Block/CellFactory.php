<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\Cell;

class CellFactory extends AbstractBlockFactory implements CellFactoryInterface
{
    public function build(array $data): Cell
    {
        return new Cell(
            $data['Id'],
            $this->getGeometryFactory()->build($data['Geometry']),
            (float)$data['Confidence'],
            (int)$data['RowIndex'],
            (int)$data['ColumnIndex'],
            (int)$data['RowSpan'],
            (int)$data['ColumnSpan'],
        );
    }
}
