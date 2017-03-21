<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CoursesModel;

/**
 * CoursesSearchModel represents the model behind the search form about `backend\models\CoursesModel`.
 */
class CoursesSearchModel extends CoursesModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_by','platform_id','language_id'], 'integer'],
            [['name', 'code', 'created_date', 'moodified_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = CoursesModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        	'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
        	'pagination' => [
        			'pageSize' => 10,
        	]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        	'platform_id' => $this->platform_id,
        	'language_id' => $this->language_id,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'moodified_date' => $this->moodified_date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}
