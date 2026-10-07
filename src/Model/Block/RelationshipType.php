<?php

namespace D9\Textract\Model\Block;

enum RelationshipType: string
{
    case VALUE = 'VALUE';
    case CHILD = 'CHILD';
    case COMPLEX_FEATURES = 'COMPLEX_FEATURES';
    case MERGED_CELL = 'MERGED_CELL';
    case TITLE = 'TITLE';
    case ANSWER = 'ANSWER';
    case TABLE_TITLE = 'TABLE_TITLE';
    case TABLE_FOOTER = 'TABLE_FOOTER';
}
