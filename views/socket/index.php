<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $user app\models\pure\User */
/* @var $models app\models\pure\Machine[] */
/* @var $page string*/

$this->title = Yii::t('app', 'Machines');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile("@web/theme/node_modules/socket.io-client/dist/socket.io.js");
$this->registerJsFile("@web/theme/custom/pages/socket/js/AbstractSocket.js",
    ['depends' => [yii\web\JqueryAsset::className()]]
);
$this->registerJsFile("@web/theme/custom/pages/socket/js/index.js",
    ['depends' => [yii\web\JqueryAsset::className()]]
);
?>
<div class="socket-index">
    <?php Pjax::begin(["id"=>"socket-pjax"]); ?>
    <?php

     switch ($page){
         case "machines":
             echo $this->render("machines",[
                     "models"=>$models,
                      "user"=>$user,
             ]);
     }

    ?>


    <?php Pjax::end()?>
</div>

