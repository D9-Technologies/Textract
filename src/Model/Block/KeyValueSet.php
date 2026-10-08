<?php

namespace D9\Textract\Model\Block;

use D9\Textract\Model\Geometry\Geometry;

class KeyValueSet extends AbstractBlock implements HasConfidenceInterface, KeyValueSetInterface
{
    private float $confidence;
    private EntityType $entityType;

    public function __construct(
        string $id,
        Geometry $geometry,
        float $confidence,
        EntityType $entityType
    ) {
        parent::__construct($id, $geometry);
        $this->confidence = $confidence;
        $this->entityType = $entityType;
    }

    public function getBlockType(): BlockType
    {
        return BlockType::KEY_VALUE_SET;
    }

    /**
     * @return float
     */
    public function getConfidence(): float
    {
        return $this->confidence;
    }

    /**
     * @return EntityType
     */
    public function getEntityType(): EntityType
    {
        return $this->entityType;
    }

    public function isKey(): bool
    {
        return $this->entityType === EntityType::KEY;
    }

    public function isValue(): bool
    {
        return $this->entityType === EntityType::VALUE;
    }

    public function isColumnHeader(): bool
    {
        return $this->entityType === EntityType::COLUMN_HEADER;
    }

    public function getKey(): string
    {
        if (!$this->isKey()) {
            throw new \RuntimeException('You can only access the key from the key block of a key value set');
        }

        $keyStrings = [];

        foreach ($this->getChildren(RelationshipType::CHILD) as $child) {
            if ($child instanceof HasTextInterface) {
                $keyStrings[] = $child->getText();
            }
        }

        return implode(' ' , $keyStrings);
    }

    /**
     * @return HasValue[]
     */
    public function getWordValues(): array
    {
        $values = [];

        if ($this->isKey()) {
            foreach ($this->getChildren(RelationshipType::VALUE) as $child) {
                if ($child instanceof KeyValueSet && $child->isValue()) {
                    $values = array_merge($child->getWordValues());
                }
            }

            return $values;
        } elseif ($this->isValue()) {
            $values = [];
            foreach ($this->getChildren(RelationshipType::CHILD) as $child) {
                if ($child instanceof HasValue && $child instanceof BlockInterface) {
                    $values[$child->getId()] = $child;
                }
            }
        }

        return array_values($values);
    }


    /**
     * @return HasValue[]
     */
    public function getLineValues(): array
    {
        $values = [];

        if ($this->isKey()) {
            foreach ($this->getChildren(RelationshipType::VALUE) as $child) {
                if ($child instanceof KeyValueSet) {
                    $values = array_merge($values, $child->getLineValues());
                }
            }
        } elseif ($this->isValue()) {
            foreach ($this->getChildren(RelationshipType::CHILD) as $child) {
                //If the child is a word, then get the line that this word comes from
                if ($child instanceof Word) {
                    foreach ($child->getParents(RelationshipType::CHILD) as $parent) {
                        if ($parent instanceof Line) {
                            $values[$parent->getId()] = $parent;
                        }
                    }
                //All other cases just return the child instead. This would be for SelectionElements which don't have a line as a parent
                } elseif ($child instanceof HasValue && $child instanceof BlockInterface) {
                    $values[$child->getId()] = $child;
                }
            }
        }

        return array_values($values);
    }
}
