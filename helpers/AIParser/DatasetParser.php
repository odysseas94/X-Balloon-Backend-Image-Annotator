<?php

namespace app\helpers\AIParser;

use app\helpers\ArrayHelper;
use app\helpers\HelperParser;
use app\models\pure\Hyperconfiguration;
use app\models\pure\TrainingWeights;
use app\models\pure\AIStatus;
/**
 *
 * @property Hyperconfiguration[] $hyperconfiguration;
 *
 * */
class DatasetParser extends HelperParser
{


    public $datasetModel = null;

    public $trainingWeight;

    public $validation;
    public $training;
    public $trainingClassifications;
    public $validation_result;
    public $training_result;
    public $hyperconfiguration;



    public function __construct($user = null)
    {

        parent::__construct($user);

        $this->datasetModel = \app\models\pure\Dataset::findBySql("select dataset.* from dataset
             inner join validation on dataset.validation_id=validation.id
            inner join training on training.id=dataset.training_id and training.status_id!=".AIStatus::FINISHED." and dataset.status_id!=".AIStatus::FINISHED)->one();

        if (!$this->datasetModel) {
            throw new \Exception("dataset not found");


        }
        $this->validation = $this->datasetModel->validation;
        $this->training = $this->datasetModel->training;
        $this->trainingClassifications = $this->training->trainingClassifications;
        $this->trainingWeight = \app\models\pure\TrainingWeights::findBySql("select * from training_weights where training_id={$this->training->id}")->one();


    }


    public function getHyperConfigurations()
    {
        $this->hyperconfiguration = Hyperconfiguration::findBySql("select hyperconfiguration.*,dataset_configuration.value as override_value from hyperconfiguration
                left join dataset_configuration on hyperconfiguration.id=dataset_configuration.configuration_id and dataset_id={$this->datasetModel->id}")->all();
        $result=[];
        foreach ($this->hyperconfiguration as $hyperconfiguration){
            $result[]=ArrayHelper::merge($hyperconfiguration->getAttributes(),[
                "override_value"=>$hyperconfiguration->override_value]);

        }
       return $result;

    }

    public function init()
    {

        $this->getValidationSet();
        $this->getTrainingSet();

        return $this->constructMainResult();

    }


    public function constructMainResult()
    {


        $dataset = array_merge($this->trainingWeight->getAttributes(), $this->datasetModel->getAttributes());


        return [

            "dataset" => $dataset,
            "hyperconfiguration" => $this->getHyperConfigurations(),
            "training" => $this->training_result,
            "validation" => $this->validation_result,

        ];


    }


    public function getValidationSet()
    {

        $validationImages = \app\models\pure\Image::findBySql("select image.* from image
          inner join validation_images on validation_images.image_id=image.id and  validation_id={$this->validation->id}  and validation_images.active='true'
          inner join image_shape on image_shape.image_id=image.id and image_shape.deleted=0")->all();
        $shapesSimplified = new \app\helpers\AIParser\ShapesSimplified($validationImages, ArrayHelper::keys($this->trainingClassifications, "classification_id"));
        $this->validation_result = $shapesSimplified->init();

    }


    public function getTrainingSet()
    {

        $trainingImages = \app\models\pure\Image::findBySql("select image.* from image 
        inner join training_images  on image.id = training_images.image_id and  training_id={$this->training->id} and training_images.active='true'
        and exists(select * from training_classification where training_images.training_id=training_classification.training_id)
        inner join image_shape on image_shape.image_id=image.id and image_shape.deleted=0;
        ")->all();

        try {


            $shapesSimplified = new \app\helpers\AIParser\ShapesSimplified($trainingImages, ArrayHelper::keys($this->trainingClassifications, "classification_id"));
            $this->training_result = $shapesSimplified->init();

        } catch (\Exception $e) {
            die($e->getMessage());
        }

    }
}


