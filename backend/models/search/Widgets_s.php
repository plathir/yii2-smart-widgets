<?php

namespace plathir\widgets\backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use plathir\widgets\backend\models\Widgets as Widgets;
use yii;

class Widgets_s extends Widgets {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'publish'], 'integer'],
            [['name', 'widget_type', 'description', 'position'], 'string'],
            [['created_at', 'updated_at'], 'date', 'format' => Yii::$app->settings->getSettings('ShortDateFormat'), 'message' => '{attribute} must be DD/MM/YYYY format.'],
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
            'publish' => $this->publish,
        ]);

        $query->andFilterWhere(['=', 'position', $this->position])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', "( FROM_UNIXTIME(`created_at`, '". Yii::$app->settings->getSettings('DBShortDateFormat')." %h:%i:%s %p' ))", $this->created_at])
                ->andFilterWhere(['like', "( FROM_UNIXTIME(`updated_at`, '". Yii::$app->settings->getSettings('DBShortDateFormat')." %h:%i:%s %p' ))", $this->updated_at]);

        return $dataProvider;
    }

}
