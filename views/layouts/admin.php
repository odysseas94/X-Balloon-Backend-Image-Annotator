<?php
/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\AppAsset;


use yii\bootstrap4\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\web\View;

AppAsset::register($this);

$web = Yii::getAlias('@web');
$viewLayoutPath = Yii::$app->basePath . '\views\layouts\main\\';

$app = $web;


$this->registerJs(
    "window.yiiPath={controller:'" . Yii::$app->controller->getUniqueId() . "',
     view:'" . Yii::$app->controller->action->id . "'};
     window.user=".\yii\helpers\Json::encode(Yii::$app->user->identity->getAttributes()),

    View::POS_HEAD);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed  kt-aside--enabled kt-aside--fixed kt-page--loading">
<?php $this->beginBody() ?>


<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
    <div class="kt-header-mobile__logo">
        <a href="<?= "./index.php?r=dashboard/" ?>">
            <img alt="Logo" class="logo-image" src="<?= "$web/theme/custom/img/logo.png" ?>"/>
        </a>
    </div>
    <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left"
                id="kt_aside_mobile_toggler"><span></span></button>

        <button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>

        <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
                    class="flaticon-more"></i></button>
    </div>
</div>
<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <!-- begin:: Aside -->
        <button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
        <?= $this->render("main/menu.php"); ?>

        <!-- end:: Aside -->
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
            <!-- begin:: Header -->
            <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">
                <!-- begin: Header Menu -->


                <!-- end: Header Menu -->        <!-- begin:: Header Topbar -->
                <?= $this->render("main/topbar.php"); ?>
                <!-- end:: Header Topbar --></div>
            <!-- end:: Header -->

            <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor"
                 id="kt_content">

                <!-- begin:: Subheader -->


                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <?=
                    Breadcrumbs::widget([
                        'homeLink' => ['url' => './index.php', 'label' => Yii::t("app", 'Home')],
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ])
                    ?>
                    <?php


                    try {
                        echo \app\widgets\Alert::widget([
                        ]);
                    } catch (Exception $e) {
                    }


                    ?>


                    <?= $content ?>
                </div>
            </div>

            <footer class="footer">
                <div class="container">
                    <p class="pull-left">&copy; X-Balloon <?= date('Y') ?></p>

                    <p class="pull-right"><?= \Yii::t('yii', 'Powered by {qbase}', [
                            'qbase' => '<a href="http://www.qbase.gr/" target="_blank" rel="external">' . \Yii::t('app',
                                    'Q Base R&D') . '</a>',
                        ]) ?></p>
                </div>
            </footer>

            <?php $this->endBody() ?>
        </div>
</body>
</html>
<?php $this->endPage() ?>
