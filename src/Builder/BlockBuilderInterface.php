<?php

namespace D9\Textract\Builder;

use D9\Textract\Factory\Block\BlockFactoryInterface;
use D9\Textract\Model\Block\BlockInterface;
use D9\Textract\Model\Block\BlockType;

interface BlockBuilderInterface
{
    public function build(array $data): BlockInterface;
    public function setBlockFactory(BlockFactoryInterface $blockFactory, BlockType $blockType): void;
}
