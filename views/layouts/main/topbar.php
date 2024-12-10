<?php

use yii\bootstrap4\Html;
$web = Yii::getAlias('@web');
?>

<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">


    <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i>
    </button>
    <!--end: Quick Actions -->

    <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">

        <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">
            <ul class="kt-menu__nav ">
                <li class="kt-menu__item " aria-haspopup="true"><a href="./index.php?r=workbench"
                                                                   target="_blank"
                                                                   class="kt-menu__link "><i
                                class="kt-menu__link-icon fas fa-tools"></i><span
                                class="kt-menu__link-text"><?= Yii::t("app", "Annotation Builder") ?></span></a></li>
            </ul>
        </div>
    </div>

    <?php
    $active_en = '';
    $active_gr = '';
    if (Yii::$app->language === "el-GR") {
        $image = "greek.svg";
        $active_gr = 'kt-nav__item--active';

    } else {
        $active_en = 'kt-nav__item--active';
        $image = "uk.svg";
    }

    ?>
    <div class="kt-header__topbar">
        <!--end: Quick panel toggler --><!--begin: Language bar -->
        <div class="kt-header__topbar-item kt-header__topbar-item--langs">
            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                                    <span class="kt-header__topbar-icon">
                                        <img class="" src="./theme/assets/img/<?= $image ?>" alt=""/>
                                    </span>
            </div>
            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround">
                <ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
                    <li class="kt-nav__item <?= $active_en ?> ">
                        <a href="index.php?r=dashboard/locale&name=en" class="kt-nav__link">
                            <span class="kt-nav__link-icon"><img src="./theme/assets/img/uk.svg" alt=""/></span>
                            <span class="kt-nav__link-text"><?= Yii::t("app", "English") ?></span>
                        </a>
                    </li>
                    <li class="kt-nav__item <?= $active_gr ?> ">
                        <a href="./index.php?r=dashboard/locale&name=el-GR" class="kt-nav__link">
                            <span class="kt-nav__link-icon"><img src="./theme/assets/img/greek.svg" alt=""/></span>
                            <span class="kt-nav__link-text"><?= Yii::t("app", "Greek") ?></span>
                        </a>
                    </li>

                    <!--                <li class="kt-nav__item">-->
                    <!--                    <a href="./index.php?r=site/locale&name=it-IT" class="kt-nav__link">-->
                    <!--                        <span class="kt-nav__link-icon"><img src="./theme/assets/img/italy.png" alt=""/></span>-->
                    <!--                        <span class="kt-nav__link-text">-->
                    <? //= Yii::t("app", "Italic") ?><!--</span>-->
                    <!--                    </a>-->
                    <!--                </li>-->

                </ul>
            </div>
        </div>
        <!--end: Language bar --><!--begin: User Bar -->
        <div class="kt-header__topbar-item kt-header__topbar-item--user">
            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" aria-expanded="false" data-offset="0px,0px">
                <div class="kt-header__topbar-user">
                    <span class="kt-header__topbar-welcome kt-hidden-mobile"><?= Yii::t("app", "Hi") ?>,</span>
                    <span class="kt-header__topbar-username kt-hidden-mobile"><?= Yii::$app->user->identity->fullname ?></span>
                    <img alt="Pic" class="kt-radius-100"
                         src="<?= Yii::$app->user->identity->image_id ? Yii::$app->user->identity->image->fullThumbnailPath : "$web/theme/custom/img/user-icon.png" ?>"/>
                    <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                    <!--<span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold">S</span>-->
                </div>
            </div>

            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-md">
                <!--begin: Head -->

                <!--end: Head -->

                <!--begin: Navigation -->
                <div class="kt-notification">
                    <a href="./index.php?r=user/update&id=<?= Yii::$app->user->id ?>" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-calendar-3 kt-font-success"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title kt-font-bold">
                                <?= Yii::t("app", "My Profile") ?>
                            </div>
                            <div class="kt-notification__item-time">
                                <?= Yii::t("app", "Settings") ?>
                            </div>
                        </div>
                    </a>


                    <div class="kt-notification__custom kt-space-between">
                        <?php
                        echo "" . Html::beginForm(['/site/logout'], 'post', ['class' => 'w-100'])
                            . Html::submitButton(
                                Yii::t("app", 'Logout'),
                                ['class' => 'btn btn-primary w-100 logout']
                            ) .
                            Html::endForm() . "";
                        ?>


                    </div>
                </div>
                <!--end: Navigation -->
            </div>
        </div>
        <!--end: User Bar -->

    </div>
</div>
