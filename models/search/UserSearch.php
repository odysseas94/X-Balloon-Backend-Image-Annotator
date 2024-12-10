<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pure\User;

/**
 * UserSearch represents the model behind the search form of `app\models\pure\User`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */

    public $gender_name;
    public function rules()
    {
        return [
            [['id', 'gender_id', 'user_type_id', 'country_id', 'status'], 'integer'],
            [['username', 'firstname', 'lastname', 'image', 'token',"gender_name", 'auth_key', 'password_hash', 'password_reset_token', 'email', 'date_created', 'date_updated', 'verification_token'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();
        $query->innerJoin("gender","gender.id=gender_id");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

           $dataProvider->sort->attributes["gender_name"] = [
            'asc' => ['gender.pretty_name' => SORT_ASC],
            'desc' => ['gender.pretty_name' => SORT_DESC],
        ];
           if(Yii::$app->user->identity->isManager)
               $query->andWhere("user.id=".Yii::$app->user->id." 
                           or exists (select user_id from user_manager where user.id=user_manager.user_id and manager_id=".Yii::$app->user->id.")");
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user.id' => $this->id,
            'gender_id' => $this->gender_id,
            'user_type_id' => $this->user_type_id,
            'country_id' => $this->country_id,
            'status' => $this->status,
            'date_updated' => $this->date_updated,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'gender.pretty_name', $this->gender_name])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'user.date_created', $this->date_created])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'verification_token', $this->verification_token]);

        return $dataProvider;
    }
}
