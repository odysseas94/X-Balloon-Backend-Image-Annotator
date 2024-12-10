<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $models \app\models\pure\Dataset[]; */

$this->title = Yii::t('app', 'Datasets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="index-page kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
					<span class="kt-portlet__head-icon">
						<i class="la la-adjust"></i>
					</span>
            <h3 class="kt-portlet__head-title">
                <?= Html::encode($this->title) ?>

            </h3>

        </div>

    </div>
</div>


<div class="row">

    <div class="col-md-12 col-xl-4 col-sm-12">
        <a href="<?= \yii\helpers\Url::to(["create"]) ?>"
           class="kt-portlet--height-fluid kt-portlet   text-center w-100 d-flex justify-content-center add-container-button btn btn-secondary color-blue">

            <div class="add-container-button">

                <i class="fa fa-plus mat-icon"></i>

            </div>
            <span class="big-letter">
                <?= Yii::t('app', 'Add Dataset') ?></span>

        </a>

    </div>
    <?php foreach ($models as $model) {
        $status = $model->status; ?>
        <div class="col-md-12 col-xl-4 col-sm-12">
            <div class="kt-portlet  kt-portlet--height-fluid">
                <div class="kt-portlet__head  kt-portlet--solid-warning">
                    <div class="kt-portlet__head-label">
					<span class="kt-portlet__head-icon">
						<i class="kt-menu__link-icon flaticon-pie-chart"></i>
					</span>
                        <h3 class="kt-portlet__head-title">
                            <?= $model->name ?> <a href="<?= \yii\helpers\Url::to(["update", "id" => $model->id]) ?>"
                                                   class="btn btn-pill btn-sm <?= $status->getHtmlLabeled() ?>"><?= Yii::t("app", $status->name) ?></a>
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-actions">


                            <a href="<?= \yii\helpers\Url::to(["view", "id" => $model->id]) ?>"
                               class="btn btn-outline-secondary btn-sm btn-icon btn-icon-md" data-placement="top"
                               data-toggle="kt-popover"
                               data-content="<?= Yii::t("app", "View") ?>">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="<?= \yii\helpers\Url::to(["update", "id" => $model->id]) ?>"
                               class="btn btn-outline-success btn-sm btn-icon btn-icon-md" data-placement="top"
                               data-toggle="kt-popover"
                               data-content="<?= Yii::t("app", "Edit") ?>">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a href="<?= \yii\helpers\Url::toRoute(["training-images/index", "TrainingImagesSearch[training_id]" => $model->training_id]) ?>"
                               class="btn btn-outline-brand btn-sm btn-icon btn-icon-md" data-placement="top"
                               data-toggle="kt-popover"
                               data-content="<?= Yii::t("app", "Training Images") ?>">
                                <i class="kt-menu__link-icon flaticon2-list-3"></i>
                            </a>
                            <a href="<?= \yii\helpers\Url::toRoute(["validation-images/index", "ValidationImagesSearch[validation_id]" => $model->validation_id]) ?>"
                               class="btn btn-outline-brand btn-sm btn-icon btn-icon-md" data-placement="top"
                               data-toggle="kt-popover"
                               data-content="<?= Yii::t("app", "Validation Images") ?>">
                                <i class="kt-menu__link-icon fas fa-check-double"></i>
                            </a>

                            <a href="#"
                               onclick="new WarningModal({actionUrl:'<?= \yii\helpers\Url::to(["delete", "id" => $model->id]) ?>'})"
                               class="btn btn-outline-danger btn-sm btn-icon btn-icon-md" data-placement="top"
                               data-toggle="kt-popover"
                               data-content="<?= Yii::t("app", "Delete") ?>">
                                <i class="fa fa-trash"></i>
                            </a>

                            <div class="btn-group" role="group">
                                <a class="btn " data-toggle="dropdown" href="#" role="button"
                                   data-placement="top"
                                   aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-ellipsis-v big-letter"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-fit-top">
                                    <a class="dropdown-item"
                                       href="<?= \yii\helpers\Url::to(["configuration", "id" => $model->id]) ?>"> <?= Yii::t("app", "R-CNN
                                        Configuration"); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-portlet__content">
                        <div class="pt-1">
                            <bold><?= Yii::t("app", "Training") ?> :</bold>
                            <a class='kt-link'
                               href="<?= \yii\helpers\Url::to(["training/index", 'TrainingSearch[id]' => $model->training_id]) ?>"> <?= $model->training->prettyName ?></a>
                        </div>
                        <div class="pt-1">
                            <bold><?= Yii::t("app", "Validation") ?> :</bold>
                            <a class='kt-link'
                               href="<?= \yii\helpers\Url::to(["validation/index", 'ValidationSearch[id]' => $model->validation_id]) ?>"> <?= $model->validation->prettyName ?></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    <?php } ?>
</div>
<!--    </div>-->
<!--</div>-->
