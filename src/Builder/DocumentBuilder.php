<?php

namespace D9\Textract\Builder;

use D9\Textract\Model\Block\Page;
use D9\Textract\Model\Block\RelationshipType;
use D9\Textract\Model\Document;

class DocumentBuilder implements DocumentBuilderInterface
{
    private BlockBuilderInterface $blockBuilder;

    public function __construct(BlockBuilderInterface $blockBuilder = null)
    {
        if (is_null($blockBuilder)) {
            $blockBuilder = new BlockBuilder();
        }

        $this->blockBuilder = $blockBuilder;
    }

    public function build(array $data): Document
    {
        $blocks = [];
        $pages = [];

        foreach ($data['Blocks'] as $blockData) {
            $block = $this->blockBuilder->build($blockData);
            $blocks[$block->getId()] = $block;

            if ($block instanceof Page) {
                $pages[] = $block;
            }
        }

        foreach ($data['Blocks'] as $blockData) {
            if (isset($blockData['Relationships']) && is_array($blockData['Relationships'])) {
                foreach($blockData['Relationships'] as $relationshipData) {
                    $relationshipType = RelationshipType::from($relationshipData['Type']);
                    foreach($relationshipData['Ids'] as $childId) {
                        $childBlock = $blocks[$childId];
                        $parentBlock = $blocks[$blockData['Id']];

                        $parentBlock->addChild($relationshipType, $childBlock);
                        $childBlock->addParent($relationshipType, $parentBlock);
                    }
                }
            }
        }

        return new Document($data['AnalyzeDocumentModelVersion'], $pages);
    }
}
