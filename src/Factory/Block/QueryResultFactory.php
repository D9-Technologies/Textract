<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\QueryResult;

class QueryResultFactory extends AbstractBlockFactory implements QueryResultFactoryInterface
{
    public function build(array $data): QueryResult
    {
        return new QueryResult(
            $data['Id'],
            $data['Geometry'] !== null ? $this->getGeometryFactory()->build($data['Geometry']) : null,
            $data['Text']
        );
    }
}
