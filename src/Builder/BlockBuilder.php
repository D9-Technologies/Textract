<?php

namespace D9\Textract\Builder;

use D9\Textract\Factory\Block\AbstractBlockFactory;
use D9\Textract\Factory\Block\BlockFactoryInterface;
use D9\Textract\Factory\Block\CellFactory;
use D9\Textract\Factory\Block\KeyValueSetFactory;
use D9\Textract\Factory\Block\LineFactory;
use D9\Textract\Factory\Block\MergedCellFactory;
use D9\Textract\Factory\Block\PageFactory;
use D9\Textract\Factory\Block\QueryFactory;
use D9\Textract\Factory\Block\QueryResultFactory;
use D9\Textract\Factory\Block\SelectionElementFactory;
use D9\Textract\Factory\Block\SignatureFactory;
use D9\Textract\Factory\Block\TableFactory;
use D9\Textract\Factory\Block\TableFooterFactory;
use D9\Textract\Factory\Block\TableTitleFactory;
use D9\Textract\Factory\Block\WordFactory;
use D9\Textract\Factory\Geometry\GeometryFactory;
use D9\Textract\Factory\Geometry\GeometryFactoryInterface;
use D9\Textract\Model\Block\BlockInterface;
use D9\Textract\Model\Block\BlockType;

class BlockBuilder implements BlockBuilderInterface
{
    private GeometryFactoryInterface $geometryFactory;

    private array $blockFactories = [];

    public function __construct(
        GeometryFactoryInterface $geometryFactory = null
    ) {
        if (is_null($geometryFactory)) {
            $geometryFactory = new GeometryFactory();
        }

        $this->geometryFactory = $geometryFactory;
    }

    public function build(array $data): BlockInterface
    {
        $blockType = BlockType::from($data['BlockType']);
        return $this->getBlockFactory($blockType)->build($data);
    }

    public function setBlockFactory(BlockFactoryInterface $blockFactory, BlockType $blockType): void
    {
        $this->blockFactories[$blockType->value] = $blockFactory;
    }

    private function getBlockFactory(BlockType $blockType): BlockFactoryInterface
    {
        if (!isset($this->blockFactories[$blockType->value])) {
            $this->setBlockFactory($this->createBlockFactory($blockType), $blockType);
        }

        return $this->blockFactories[$blockType->value];
    }

    private function createBlockFactory(BlockType $blockType): BlockFactoryInterface
    {
        switch ($blockType) {
            case BlockType::PAGE:
                return new PageFactory($this->geometryFactory);
            case BlockType::LINE:
                return new LineFactory($this->geometryFactory);
            case BlockType::WORD:
                return new WordFactory($this->geometryFactory);
            case BlockType::TABLE:
                return new TableFactory($this->geometryFactory);
            case BlockType::CELL:
                return new CellFactory($this->geometryFactory);
            case BlockType::KEY_VALUE_SET:
                return new KeyValueSetFactory($this->geometryFactory);
            case BlockType::MERGED_CELL:
                return new MergedCellFactory($this->geometryFactory);
            case BlockType::SELECTION_ELEMENT:
                return new SelectionElementFactory($this->geometryFactory);
            case BlockType::SIGNATURE:
                return new SignatureFactory($this->geometryFactory);
            case BlockType::QUERY:
                return new QueryFactory($this->geometryFactory);
            case BlockType::QUERY_RESULT:
                return new QueryResultFactory($this->geometryFactory);
            case BlockType::TABLE_TITLE:
                return new TableTitleFactory($this->geometryFactory);
            case BlockType::TABLE_FOOTER:
                return new TableFooterFactory($this->geometryFactory);
        }

        throw new \RuntimeException('Unknown block type: ' . $blockType->value);
    }
}
