<?php

namespace app\helpers\Override;

use kartik\grid\ColumnTrait;


abstract class AbstractColumn extends \kartik\grid\DataColumn
{
    use ColumnTrait;
}


class DataColumn extends AbstractColumn
{
    public $vAlign = GridView::ALIGN_MIDDLE;



}

