<?php
$web = Yii::getAlias('@web');
$menuHelper = null;
$active = "kt-menu__item--here";
$controller_name = Yii::$app->controller->getUniqueId();
$dashboardActive = Yii::$app->controller->getUniqueId() === "dashboard" ? $active : "";
if (Yii::$app->user->identity->isAdmin)
    $menuHelper = new \app\helpers\menu\AdminMenu();

else
    $menuHelper = new \app\helpers\menu\DoctorMenu();

$menu = $menuHelper->getMenu();
$arrangement = $menuHelper->getArrangement();
?>


<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop"
     id="kt_aside">
    <!-- begin:: Aside -->
    <div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
        <div class="kt-aside__brand-logo">
            <a href="<?= "./index.php?r=dashboard/" ?>">
                <img alt="Logo" class="logo-image rounded-circle"
                     src="<?= "$web/theme/custom/img/logo.png" ?>"/>
            </a>
        </div>

        <div class="kt-aside__brand-tools">
            <button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler"><span></span></button>
        </div>
    </div>
    <!-- end:: Aside -->    <!-- begin:: Aside Menu -->
    <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
        <div
                id="kt_aside_menu"
                class="kt-aside-menu "
                data-ktmenu-vertical="1"
                data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">

            <ul class="kt-menu__nav ">
                <?php
                $isActive = false;

                $menuStr = '';
                foreach ($arrangement

                         as $arrangementItem) {

                    $single = true;
                    $isActive = false;
                    $activeMenu = "";
                    if (isset($menu[$arrangementItem]))
                        $item = $menu[$arrangementItem];
                    else continue;


                    if (isset($item["inner"]) && is_array($item["inner"]))
                        $single = false;


                    if ($single) {


                        try {
                            if ($controller_name === $item["controller"]) {
                                $primaryActive = $active;
                                $isActive = "$active";
                            }

                            $menuStr .= '<li class="kt-menu__item ' . $isActive . '" aria-haspopup="true"><a href="' . $item["link"] . '"
                                                                                            class="kt-menu__link "><i
                                        class="' . $item["icon"] . '"></i><span
                                        class="kt-menu__link-text">' . Yii::t("app", $item["name"]) . '</span></a></li>';


                        } catch (\Exception $e) {
                            var_dump($e->getMessage());
                        }


                    } else {


                        $secondaryStr = '';


                        foreach ($item["inner"] as $innerItem) {
                            $isActive = false;
                            if ($controller_name === $innerItem["controller"]) {
                                $primaryActive = $active;
                                $isActive = "kt-menu__item--active";
                                $activeMenu = " kt-menu__item--open kt-menu__item--here";
                            }


                            $secondaryStr .= ' <li class="kt-menu__item  ' . $isActive . '" aria-haspopup="true">
                                <a href="' . $innerItem["link"] . '" class="kt-menu__link "><i
                                            class="' . $innerItem["icon"] . '"></i><span
                                            class="kt-menu__link-text">' . Yii::t("app", $innerItem["name"]) . '</span></a>
                            </li>';


                        }


                        $menuStr .= '<li class="kt-menu__item  kt-menu__item--submenu ' . $activeMenu . '" aria-haspopup="true"
                    data-ktmenu-submenu-toggle="hover"><a href="javascript:;"
                                                          class="kt-menu__link kt-menu__toggle"><i
                                class="' . $item["icon"] . '"></i><span
                                class="kt-menu__link-text">' . Yii::t("app", $item["name"]) . '</span><i
                                class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">';

                        $menuStr .= $secondaryStr;
                        $menuStr .= "  </ul>
                                </div>
                            </li>
            
                            ";


                    }


                }

                echo $menuStr;

                ?>
            </ul>
        </div>
    </div>
    <!-- end:: Aside Menu --></div>