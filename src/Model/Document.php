<?php

namespace D9\Textract\Model;

use D9\Textract\Model\Block\Page;

class Document
{
    private string $version;
    /**
     * @var Page[]
     */
    private array $pages;

    public function __construct(string $version, array $pages)
    {
        $this->version = $version;
        $this->pages = $pages;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return Page[]
     */
    public function getPages(): array
    {
        return $this->pages;
    }
}
