<?php
/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
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
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed">
<?php $this->beginBody() ?>

<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor background-white"
             id="kt_content">

            <!-- begin:: Subheader -->


            <div class="kt-container container-error  kt-container--fluid  kt-grid__item kt-grid__item--fluid background-white">
                <?= Alert::widget() ?>

                <div>
                    <?= $content ?>
                </div>
            </div>
        </div>

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
</body>
</html>
<?php $this->endPage() ?>
