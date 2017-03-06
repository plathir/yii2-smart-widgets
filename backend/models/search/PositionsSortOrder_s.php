<?php

namespace plathir\widgets\backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use plathir\widgets\backend\models\PositionsSortOrder;


class PositionsSortOrder_s extends PositionsSortOrder {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['position_tech_name'], 'string'],
            [['widget_sort_ordrr'], 'string'],
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
        $query = PositionsSortOrder::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'position_tech_name' => $this->position_tech_name,
        ]);

        return $dataProvider;
    }

}
