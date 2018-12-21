<?php

namespace plathir\widgets\backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use plathir\widgets\backend\models\Layouts;

class Layouts_s extends Layouts {

    public $environment;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['tech_name'], 'string'],
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
        $query = Layouts::find();

        $query->select(['*', "SUBSTRING(module_name,1,LOCATE('-',module_name)- 1) AS environment"]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'tech_name',
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

        $query->andFilterWhere(['publish' => $this->publish])
                ->andFilterWhere(['like', 'tech_name', $this->tech_name])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'path', $this->path])
                ->andFilterWhere(['like', 'module_name', $this->module_name])
                ->andFilterWhere(['like', "SUBSTRING(module_name,1,LOCATE('-',module_name)-1)", $this->environment]);

        return $dataProvider;
    }

}
