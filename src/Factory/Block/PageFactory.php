<?php

namespace D9\Textract\Factory\Block;

use D9\Textract\Model\Block\Page;

class PageFactory extends AbstractBlockFactory implements PageFactoryInterface
{
    public function build(array $data): Page
    {
        return new Page(
            $data['Id'],
            $this->getGeometryFactory()->build($data['Geometry'])
        );
    }
}
