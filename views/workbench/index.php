<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\web\View;

$this->title = Yii::t("app", "WorkBench");
$script = "localDomain='".Yii::getAlias("@web")."/ai-parser/AttributeParser-X-Balloon';
urlConnectionApi='".Url::base(true) ."/index.php?r=api/v1/workbench/'";

$this->registerJs($script, View::POS_BEGIN, 'my-options');

?>

<div class="main-body header-body">
    <div class="tabs">

        <div class="logo-name" title="Builder Image Annotator">
            Builder I.A.


        </div>


    </div>

</div>


<div class="canvas-parent">


</div>

</div>
<!--<canvas id="canvas" width="1000" height="1000"></canvas>-->


<div class="global-appender">

</div>
<div class="loading"></div>


