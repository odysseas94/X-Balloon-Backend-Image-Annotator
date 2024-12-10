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
    <body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed" >
        <?php $this->beginBody() ?>



        <?= Alert::widget() ?>
        
        <div>
        <?= $content ?>
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
