<?php

namespace app\helpers\menu;

class DoctorMenu extends MenuHelper
{

    public function getArrangement(): array
    {
        return ["dashboard", "Annotation", "Training", "Validation", "Testing","dataset", "weight-files",
        ];
    }

    public function getMenu(): array
    {

        $menu = [];
        $menu["dashboard"] = ["controller" => "dashboard", "link" => \yii\helpers\Url::toRoute(["dashboard/index"]), 'name' => "Dashboard", "icon" => "kt-menu__link-icon flaticon-graphic"];
        $menu["Annotation"] = ["name" => "Annotation", "icon" => "kt-menu__link-icon flaticon2-list-3",
            "inner" => [["controller" => "image", "link" => \yii\helpers\Url::toRoute(["image/index"]), 'name' => "Images", 'icon' => "kt-menu__link-icon flaticon2-image-file"],
                ["controller" => "shape", "link" => \yii\helpers\Url::toRoute(["shape/index"]), 'name' => "Findings", "icon" => "kt-menu__link-icon flaticon-graph"],]];

        $menu["shape"] = ["controller" => "shape", "link" => \yii\helpers\Url::toRoute(["shape/index"]), 'name' => "Findings", "icon" => "kt-menu__link-icon flaticon-graph"];


        $menu["Training"] = ["name" => "Training", "icon" => "kt-menu__link-icon flaticon2-list-3",
            "inner" => [["controller" => "training", "link" => \yii\helpers\Url::toRoute(["training/index"]), "name" => 'Set', "icon" => "kt-menu__link-icon fa fa-globe"],
                ["controller" => "training-images", "link" => \yii\helpers\Url::toRoute(["training-images/index"]), "name" => "Training Images", "icon" => "kt-menu__link-icon fa fa-images"],
                ["controller" => "training-weights", "link" => \yii\helpers\Url::toRoute(["training-weights/index"]), 'name' => "Training Weights", "icon" => "kt-menu__link-icon flaticon2-pie-chart-2"]],
        ];
        $menu["Validation"] = ["name" => "Validation", "icon" => "kt-menu__link-icon fas fa-check-double",
            "inner" => [["controller" => "validation", "link" => \yii\helpers\Url::toRoute(["validation/index"]), "name" => 'Set', "icon" => "kt-menu__link-icon fa fa-globe"],
                ["controller" => "validation-images", "link" => \yii\helpers\Url::toRoute(["validation-images/index"]), "name" => "Testing Images", "icon" => "kt-menu__link-icon fa fa-images"]],
        ];
        $menu["Testing"] = ["name" => "Testing", "icon" => "kt-menu__link-icon fas fa-vials",
            "inner" => [["controller" => "testing", "link" => \yii\helpers\Url::toRoute(["testing/index"]), "name" => 'Set', "icon" => "kt-menu__link-icon fa fa-globe"],
                ["controller" => "testing-images", "link" => \yii\helpers\Url::toRoute(["testing-images/index"]), "name" => "Testing Images", "icon" => "kt-menu__link-icon fa fa-images"],
                ["controller" => "conclusion", "link" => \yii\helpers\Url::toRoute(["conclusion/index"]), 'name' => "Conclusions", "icon" => "kt-menu__link-icon fa fa-list-alt"]],
        ];


        $menu["dataset"] = ["controller" => "dataset", "link" => \yii\helpers\Url::toRoute(["dataset/index"]), 'name' => "Dataset", "icon" => "kt-menu__link-icon flaticon-pie-chart"];
        $menu["weight-files"] = ["controller" => "weight-file", "link" => \yii\helpers\Url::toRoute(["weight-file/index"]), 'name' => "Weight Files", "icon" => "kt-menu__link-icon fas fa-file-code"];


        return $menu;

    }

}