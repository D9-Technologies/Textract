<?php

namespace D9\Textract\Model\Geometry;

class BoundingBox
{
    private float $width;
    private float $height;
    private float $left;
    private float $top;

    public function __construct(
        float $width,
        float $height,
        float $left,
        float $top
    ) {
        $this->width = $width;
        $this->height = $height;
        $this->left = $left;
        $this->top = $top;
    }

    /**
     * @return float
     */
    public function getWidth(): float
    {
        return $this->width;
    }

    /**
     * @return float
     */
    public function getHeight(): float
    {
        return $this->height;
    }

    /**
     * @return float
     */
    public function getLeft(): float
    {
        return $this->left;
    }

    /**
     * @return float
     */
    public function getTop(): float
    {
        return $this->top;
    }
}
