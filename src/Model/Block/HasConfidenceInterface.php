<?php

namespace D9\Textract\Model\Block;

interface HasConfidenceInterface
{
    public function getConfidence(): float;
}
