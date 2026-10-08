<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\SelectionElement;
use D9\Textract\Model\Block\SelectionStatus;

class SelectionElementFactory extends AbstractBlockFactory implements SelectionElementFactoryInterface
{
    public function build(array $data): SelectionElement
    {
        return new SelectionElement(
            $data['Id'],
            $this->getGeometryFactory()->build($data['Geometry']),
            (float)$data['Confidence'],
            SelectionStatus::from($data['SelectionStatus'])
        );
    }
}
