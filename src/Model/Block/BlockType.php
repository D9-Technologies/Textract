<?php

namespace D9\Textract\Model\Block;

enum BlockType: string
{
    case PAGE = 'PAGE';
    case LINE = 'LINE';
    case WORD = 'WORD';
    case TABLE = 'TABLE';
    case CELL = 'CELL';
    case KEY_VALUE_SET = 'KEY_VALUE_SET';
    case MERGED_CELL = 'MERGED_CELL';
    case SELECTION_ELEMENT = 'SELECTION_ELEMENT';
    case SIGNATURE = 'SIGNATURE';
    case QUERY = 'QUERY';
    case QUERY_RESULT = 'QUERY_RESULT';
    case TABLE_TITLE = 'TABLE_TITLE';
    case TABLE_FOOTER = 'TABLE_FOOTER';


}
