<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\Word;

class WordFactory extends AbstractBlockFactory implements WordFactoryInterface
{
    public function build(array $data): Word
    {
        return new Word(
            $data['Id'],
            $this->getGeometryFactory()->build($data['Geometry']),
            (float)$data['Confidence'],
            $data['Text'],
        );
    }
}
