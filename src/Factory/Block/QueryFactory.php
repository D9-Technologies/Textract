<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\Query;

class QueryFactory extends AbstractBlockFactory implements QueryFactoryInterface
{
    public function build(array $data): Query
    {
        return new Query(
            $data['Id'],
             array_key_exists('Geometry', $data) ? $this->getGeometryFactory()->build($data['Geometry']) : null,
            $data['Query']['Alias'],
            $data['Query']['Text']
        );
    }
}