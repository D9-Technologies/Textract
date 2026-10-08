<?php

namespace D9\Textract\Model\Geometry;

class Polygon
{
    /**
     * @var Point[]
     */
    private array $points;

    public function __construct(array $points)
    {
        $this->points = $points;
    }

    /**
     * @return Point[]
     */
    public function getPoints(): array
    {
        return $this->points;
    }
}
