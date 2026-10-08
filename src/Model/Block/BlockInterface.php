<?php

namespace D9\Textract\Model\Block;

interface BlockInterface
{
    public function getId(): string;

    public function getBlockType(): BlockType;
    public function addChild(RelationshipType $relationshipType, BlockInterface $block);

    public function addParent(RelationshipType $relationshipType, BlockInterface $block);

    /**
     * @param RelationshipType $relationshipType
     * @return BlockInterface[]
     */
    public function getChildren(RelationshipType $relationshipType): array;

    /**
     * @param RelationshipType $relationshipType
     * @return BlockInterface[]
     */
    public function getParents(RelationshipType $relationshipType): array;
}
