<?php

namespace app\helpers\Override;
class GridView extends \kartik\grid\GridView
{
    public $dataColumnClass = 'app\helpers\Override\DataColumn';

    public $panel = [

        'type' => 'default',

    ];

    public $toolbar = [
        [
            'content' => "",

            'options' => ['class' => 'btn-group-sm']
        ],
        '{toggleData}'
    ];

    public $condensed = true;


}


