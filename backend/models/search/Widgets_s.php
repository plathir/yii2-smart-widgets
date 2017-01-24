<?php

namespace plathir\widgets\backend\models\search;


use yii\base\Model;
use yii\data\ActiveDataProvider;
use plathir\widgets\backend\models\Widgets as Widgets;


class Widgets_s extends Widgets {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'widget_type', 'publish'], 'integer'],
            [['name', 'description', 'position' ], 'string'],
            [['created_at', 'updated_at' ], 'integer'],
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
            'widget_type' => $this->widget_type,
            'publish' => $this->publish ,
        ]);

         $query->andFilterWhere(['like', 'widget_type', $this->widget_type])
               ->andFilterWhere(['=', 'position', $this->position])
               ->andFilterWhere(['like', 'description', $this->description]);
                 
        
        return $dataProvider;
    }

}
