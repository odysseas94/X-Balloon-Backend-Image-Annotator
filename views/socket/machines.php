<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\pure\User */
/* @var $models app\models\pure\Machine[] */


?>


<div class="socket">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row machines">
        <?php foreach ($models as $model) {
            $details = $model->getFullDetailsLabeled();

            $machineStatus = $model->machineStatus;
            $disabled = $model->machine_status_id === 1 ? "" : "disabled";

            ?>
            <div class="col-xl-4 machine" data-machine-id="<?= $model->id ?>">
                <!--begin::Portlet-->
                <div class="kt-portlet <?= $machineStatus->getLabelByName() ?> kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
					<span class="kt-portlet__head-icon">
					<i class="fas fa-microchip"></i>
					</span>
                            <h3 class="kt-portlet__head-title">
                                <?= $model->name . " ($model->os)  " . Yii::t("app", $machineStatus->pretty_name) ?>
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-actions">
                                <button <?= $disabled ?>
                                        class="btn start-training btn-outline-light btn-pill btn-sm btn-icon btn-icon-md"
                                        data-container="body" data-toggle="kt-tooltip" data-placement="top" title=""
                                        data-original-title="<?= Yii::t("app", "Start Training") ?>">
                                    <i class="flaticon2-list-3"></i>
                                </button>
                                <button <?= $disabled ?>
                                        class="btn start-validation btn-outline-light btn-pill btn-sm btn-icon btn-icon-md"
                                        data-container="body" data-toggle="kt-tooltip" data-placement="top" title=""
                                        data-original-title="<?= Yii::t("app", "Start Testing") ?>">
                                    <i class="fas fa-vials"></i>
                                </button>

                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-portlet__content">
                            <ul>
                                <li><?= $details["ram"] ?></li>
                            </ul>
                            <h6 class="">  <?= Yii::t("app", "CPU") ?></h6>
                            <ul>
                                <li><?= $details["cpu"]["name"] ?></li>
                                <li><?= $details["cpu"]["cores"] ?></li>
                            </ul>

                            <?php if (count($details["gpus"])) {
                                $count = 0;
                                echo "<h6> " . Yii::t("app", "GPU") . "</h6>";

                                foreach ($details["gpus"] as $gpu) {
                                    $count++;


                                    echo " <ul><li> {$gpu["name"]}</li>
                                <li>{$gpu["vram"]}</li></ul>";
                                }


                            } ?>
                        </div>
                    </div>
                    <div class="kt-portlet__foot kt-portlet__foot--sm kt-align-right">

                        <a href="#" class="btn btn-font-light btn-outline-hover-light">View</a>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        <?php } ?>
    </div>
</div>
