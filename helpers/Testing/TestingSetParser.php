<?php

namespace app\helpers\Testing;


use app\helpers\ArrayHelper;
use app\helpers\HelperParser;
use app\models\pure\Dataset;
use app\models\pure\Hyperconfiguration;
use app\models\pure\Image;
use app\models\pure\Testing;
use app\models\pure\TestingImages;

/**
 *
 * @property Hyperconfiguration[] $hyperconfiguration;
 *
 * */
class TestingSetParser extends HelperParser
{


    public $model = null;
    public $images = [];
    public $dataset = null;
    private $trainingWeight = null;
    public $hyperconfiguration;

    public function __construct($user = null)

    {
        parent::__construct($user);


        $this->model = Testing::findBySql("select testing.* from testing 
                inner join dataset on dataset.id=testing.dataset_id
                 where testing.active='true' and testing.status_id<3")->one();
        if ($this->model) {


            $this->dataset = Dataset::findOne(["id" => $this->model->dataset_id]);
            $this->trainingWeight = \app\models\pure\TrainingWeights::findBySql("select * from training_weights where training_id={$this->dataset->training_id}")->one();

        }


    }

    public function getImages()
    {

        $images = Image::findBySql("select image.* from image 
          inner join testing_images on testing_images.image_id=image.id and testing_id={$this->model->id}")->all();
        $result = [];
        foreach ($images as $image)
            $result[$image->id] = ["image_attributes" => $image->getAttributes()];

        return $result;


    }

    public function getHyperConfigurations()
    {

        $this->hyperconfiguration = Hyperconfiguration::findBySql("select hyperconfiguration.*, nullif(testing_configuration.value,dataset_configuration.value) as override_value
              from testing_configuration 
            inner join testing on testing.id=testing_configuration.testing_id
            right join hyperconfiguration on hyperconfiguration.id=testing_configuration.configuration_id and testing_id={$this->model->id}
            left join dataset_configuration on dataset_configuration.configuration_id=hyperconfiguration.id and dataset_configuration.dataset_id={$this->dataset->id}")->all();

        $result = [];
        foreach ($this->hyperconfiguration as $hyperconfiguration) {
            $result[] = ArrayHelper::merge($hyperconfiguration->getAttributes(), [
                "override_value" => $hyperconfiguration->override_value]);

        }
        return $result;

    }

    public function init()
    {

        if ($this->model) {

            $dataset = array_merge($this->trainingWeight->getAttributes(), $this->dataset->getAttributes());

            $this->result ["dataset"] = $dataset;
            $this->result["hyperconfiguration"] = $this->getHyperConfigurations();
            $this->result["testing"] = $this->model->getAttributes();
            $this->result["testing_images"] = $this->getImages();
        }

        return $this->result;

    }
}