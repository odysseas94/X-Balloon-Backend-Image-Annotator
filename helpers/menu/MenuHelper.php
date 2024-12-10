<?php

namespace app\helpers\menu;
abstract class MenuHelper
{
    public function __construct()
    {
    }


    public function getArrangement(): array
    {
        return [];
    }

    public function getMenu(): array
    {
        return [];
    }


}