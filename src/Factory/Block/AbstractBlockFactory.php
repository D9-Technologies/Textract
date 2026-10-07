<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Factory\Geometry\GeometryFactory;
use D9\Textract\Factory\Geometry\GeometryFactoryInterface;
use D9\Textract\Model\Block\BlockInterface;

abstract class AbstractBlockFactory implements BlockFactoryInterface
{
    private GeometryFactoryInterface $geometryFactory;

    public function __construct(GeometryFactoryInterface $geometryFactory = null)
    {
        if (is_null($geometryFactory)) {
            $geometryFactory = new GeometryFactory();
        }

        $this->geometryFactory = $geometryFactory;
    }

    /**
     * @return GeometryFactoryInterface
     */
    protected function getGeometryFactory(): GeometryFactoryInterface
    {
        return $this->geometryFactory;
    }

    abstract public function build(array $data): BlockInterface;
}
