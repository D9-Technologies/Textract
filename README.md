D9 Textract
================

This library provides an object based data structure for data returned from AWS's Textract Service.
It turns the flat list of blocks in an `AnalyzeDocument` response into a graph of typed PHP objects,
so you can walk pages, lines, key/value pairs, queries and tables without handling raw arrays.

Installation
------------

```bash
composer require d9-technologies/textract
```

Requires PHP 8.1 or later.

Usage
-----

### Building a document

Pass the decoded Textract response to `DocumentBuilder::build()`. It returns a `Document` holding
each `Page` in the response.

```php
use D9\Textract\Builder\DocumentBuilder;

$response = $textractClient->analyzeDocument([...])->toArray();

$document = (new DocumentBuilder())->build($response);

$document->getVersion(); // AnalyzeDocumentModelVersion
$document->getPages();   // Page[]
```

### Pages

`Page` has shortcuts for the most common lookups:

```php
foreach ($document->getPages() as $page) {
    $page->getAllLineText();  // string[] of every line on the page
    $page->getKeyValueSets(); // KeyValueSet[] (the KEY side of each form field)
    $page->getQueries();      // Query[]
}
```

### Form fields (key/value sets)

```php
foreach ($page->getKeyValueSets() as $field) {
    $field->getKey();        // "Employee's social security number"
    $field->getLineValues(); // Line[] (or SelectionElement[]) holding the value
    $field->getWordValues(); // Word[] (or SelectionElement[]) holding the value
    $field->getConfidence();
}
```

Checkboxes and radio buttons come back as `SelectionElement`. Call `isSelected()` (or `getValue()`)
to read them.

### Queries

When you send `Queries` to Textract, each `Query` is linked to its answers through the `ANSWER`
relationship:

```php
use D9\Textract\Model\Block\RelationshipType;

foreach ($page->getQueries() as $query) {
    $query->getAlias();
    $query->getText();

    foreach ($query->getChildren(RelationshipType::ANSWER) as $result) {
        $result->getText(); // QueryResult
    }
}
```

### Navigating blocks

Every block implements `BlockInterface`. Use `getChildren()` and `getParents()` with a
`RelationshipType` to move through the graph. For example, a `Table`'s cells are its
`RelationshipType::CHILD` children, and each `Cell` exposes `getRowIndex()`, `getColumnIndex()`,
`getRowSpan()` and `getColumnSpan()`.

```php
$block->getId();
$block->getBlockType();     // BlockType enum
$block->getGeometry();      // ?Geometry with getBoundingBox() and getPolygon()
$block->getChildren(RelationshipType::CHILD);
$block->getParents(RelationshipType::CHILD);
```

Block types: `Page`, `Line`, `Word`, `KeyValueSet`, `SelectionElement`, `Table`, `Cell`,
`MergedCell`, `TableTitle`, `TableFooter`, `Query`, `QueryResult` and `Signature`, all under
`D9\Textract\Model\Block`. `Line`, `Word`, `Query` and `QueryResult` implement
`HasTextInterface` (`getText()`), and blocks with a confidence score implement
`HasConfidenceInterface` (`getConfidence()`).

### Customising construction

`DocumentBuilder` accepts an optional `BlockBuilderInterface`. To change how a single block type is
built, register your own factory on the default `BlockBuilder`:

```php
use D9\Textract\Builder\BlockBuilder;
use D9\Textract\Builder\DocumentBuilder;
use D9\Textract\Model\Block\BlockType;

$blockBuilder = new BlockBuilder();
$blockBuilder->setBlockFactory(new MyLineFactory(), BlockType::LINE);

$document = (new DocumentBuilder($blockBuilder))->build($response);
```

Testing
-------

```bash
composer install
vendor/bin/phpunit tests
```
