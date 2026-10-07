<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\SelectionElement;
use D9\Textract\Model\Block\Signature;

class SignatureFactory extends AbstractBlockFactory implements SignatureFactoryInterface
{
    public function build(array $data): Signature
    {
        return new Signature(
            $data['Id'],
            $this->getGeometryFactory()->build($data['Geometry'])
        );
    }
}
