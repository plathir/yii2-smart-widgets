<?php

namespace plathir\widgets\backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use plathir\widgets\backend\models\Positions;


class Positions_s extends Positions {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['name', 'module_name' ], 'string'],
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        $query->andFilterWhere(['id' => $this->id])
        ->andFilterWhere(['publish' => $this->publish])
        ->andFilterWhere(['like', 'name', $this->name])
        ->andFilterWhere(['like', 'module_name', $this->module_name]);
                 
        
        return $dataProvider;
    }

}
