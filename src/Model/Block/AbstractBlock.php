<?php

namespace D9\Textract\Model\Block;

use D9\Textract\Model\Geometry\Geometry;

abstract class AbstractBlock implements BlockInterface
{
    private string $id;
    private ?Geometry $geometry;

    private array $children = [];
    private array $parents = [];

    public function __construct(string $id, ?Geometry $geometry)
    {
        $this->id = $id;
        $this->geometry = $geometry;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return ?Geometry
     */
    public function getGeometry(): ?Geometry
    {
        return $this->geometry;
    }

    public function addChild(RelationshipType $relationshipType, BlockInterface $block)
    {
        if (!isset($this->children[$relationshipType->value])) {
            $this->children[$relationshipType->value] = [];
        }
        $this->children[$relationshipType->value][] = $block;
    }

    public function addParent(RelationshipType $relationshipType, BlockInterface $block)
    {
        if (!isset($this->parents[$relationshipType->value])) {
            $this->parents[$relationshipType->value] = [];
        }
        $this->parents[$relationshipType->value][] = $block;
    }

    /**
     * @param RelationshipType $relationshipType
     * @return BlockInterface[]
     */
    public function getChildren(RelationshipType $relationshipType): array
    {
        if (isset($this->children[$relationshipType->value])) {
            return $this->children[$relationshipType->value];
        }

        return [];
    }

    /**
     * @param RelationshipType $relationshipType
     * @return BlockInterface[]
     */
    public function getParents(RelationshipType $relationshipType): array
    {
        if (isset($this->parents[$relationshipType->value])) {
            return $this->parents[$relationshipType->value];
        }

        return [];
    }
}
