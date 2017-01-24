<?php

namespace plathir\widgets\backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use plathir\widgets\backend\models\Positions;

class Positions_s extends Positions {

    public $environment;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['name', 'module_name'], 'string'],
            [['environment'], 'safe'],
            [['publish'], 'integer']
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Positions::find();

        $query->select(['*', "SUBSTRING(module_name,1,LOCATE('-',module_name)- 1) AS environment"]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'name',
                'name',
                'module_name',
                'publish',
                'environment' => [
                    'asc' => ['environment' => SORT_ASC],
                    'desc' => ['environment' => SORT_DESC],
                    'label' => 'Environment',
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id])
                ->andFilterWhere(['publish' => $this->publish])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'module_name', $this->module_name])
                ->andFilterWhere(['like', "SUBSTRING(module_name,1,LOCATE('-',module_name)-1)", $this->environment]);

        return $dataProvider;
    }

}
