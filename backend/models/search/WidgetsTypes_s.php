<?php

namespace plathir\widgets\backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use plathir\widgets\backend\models\WidgetsTypes as Widgets;


class WidgetsTypes_s extends Widgets {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['module_name', 'widget_name', 'widget_class', 'description', ], 'string'],
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
            'module_name' => $this->module_name,
        ]);

         $query->andFilterWhere(['like', 'widget_name', $this->widget_name])
               ->andFilterWhere(['like', 'widget_class', $this->widget_class])
               ->andFilterWhere(['like', 'description', $this->description]);
                 
        
        return $dataProvider;
    }

}
