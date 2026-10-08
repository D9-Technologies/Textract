<?php

namespace D9\Textract\Model\Block;



class Page extends AbstractBlock
{
    public function getBlockType(): BlockType
    {
        return BlockType::PAGE;
    }

    /**
     * @return KeyValueSet[]
     */
    public function getKeyValueSets(): array
    {
        $keyValueSets = [];

        foreach ($this->getChildren(RelationshipType::CHILD) as $child) {
            if ($child instanceof KeyValueSet && $child->isKey()) {
                $keyValueSets[] = $child;
            }
        }

        return $keyValueSets;
    }

    public function getQueries(): array
    {
        $queries = [];

        foreach ($this->getChildren(RelationshipType::CHILD) as $child) {
            if ($child instanceof Query) {
                $queries[] = $child;
            }
        }

        return $queries;
    }


    /**
     * Returns an array of the text of all the lines on the page
     * @return array<int, string>
     */
    public function getAllLineText(): array
    {
        $lines = [];

        foreach ($this->getChildren(RelationshipType::CHILD) as $child) {
            if ($child instanceof Line) {
                $lines[] = $child->getText();
            }
        }

        return $lines;
    }

}
