<?php

namespace D9\Textract\Model\Geometry;

class Geometry
{
    private BoundingBox $boundingBox;
    private Polygon $polygon;

    public function __construct(BoundingBox $boundingBox, Polygon $polygon)
    {
        $this->boundingBox = $boundingBox;
        $this->polygon = $polygon;
    }

    /**
     * @return BoundingBox
     */
    public function getBoundingBox(): BoundingBox
    {
        return $this->boundingBox;
    }

    /**
     * @return Polygon
     */
    public function getPolygon(): Polygon
    {
        return $this->polygon;
    }
}
