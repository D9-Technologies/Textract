<?php

namespace D9\Textract\Model\Block;

enum SelectionStatus: string
{
    case SELECTED = 'SELECTED';
    case NOT_SELECTED = 'NOT_SELECTED';
}
