<?php

namespace plathir\widgets\backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use plathir\widgets\backend\models\WidgetsTypes as Widgets;


class WidgetsTypes_s extends Widgets {
   public $environment;
   
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['tech_name'], 'string'],
            [['module_name', 'widget_name', 'widget_class', 'description', ], 'string'],
            [['environment'], 'safe'],
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
        $query = Widgets::find();

        $query->select(['*', "SUBSTRING(module_name,1,LOCATE('-',module_name)- 1) AS environment"]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'tech_name',
                'module_name',
                'widget_name',
                'widget_class',
                'description',
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
        
        $query->andFilterWhere([
            'module_name' => $this->module_name,
        ]);

         $query->andFilterWhere(['like', 'widget_name', $this->widget_name])
               ->andFilterWhere(['like', 'widget_class', $this->widget_class])
               ->andFilterWhere(['like', 'tech_name', $this->tech_name])
               ->andFilterWhere(['like', 'description', $this->description])
               ->andFilterWhere(['like', "SUBSTRING(module_name,1,LOCATE('-',module_name)-1)", $this->environment]);
                 
        
        return $dataProvider;
    }

}
