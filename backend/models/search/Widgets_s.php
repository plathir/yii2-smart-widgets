<?php
namespace plathir\widgets\backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use plathir\widgets\backend\models\Widgets as Widgets;
use yii;

class Widgets_s extends Widgets {

    public $environment;
    public $module_name;


    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'publish'], 'integer'],
            [['name', 'widget_type', 'description', 'position'], 'string'],
            [['environment', 'name_pos'], 'safe'],
            [['module_name'], 'safe'],
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
        $query->joinWith(['widgetref']);
        $query->joinWith(['positionref']);

        $query->select(['{{%widgets}}.*', 
                        "SUBSTRING({{%widgets_positions}}.module_name,1,LOCATE('-',{{%widgets_positions}}.module_name)- 1) AS environment"
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'w_name',
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

        $query->andFilterWhere([
            'id' => $this->id,
            'widget_type' => $this->widget_type,
            'publish' => $this->publish,
        ]);

        $query->andFilterWhere(['=', 'position', $this->position])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', "( FROM_UNIXTIME(`created_at`, '" . Yii::$app->settings->getSettings('DBShortDateFormat') . " %h:%i:%s %p' ))", $this->created_at])
                ->andFilterWhere(['like', "( FROM_UNIXTIME(`updated_at`, '" . Yii::$app->settings->getSettings('DBShortDateFormat') . " %h:%i:%s %p' ))", $this->updated_at])
                ->andFilterWhere(['like', '{{%widgets_positions}}.module_name', $this->module_name])
                ->andFilterWhere(['like', "SUBSTRING({{%widgets_positions}}.module_name,1,LOCATE('-',module_name)-1)", $this->environment]);

        return $dataProvider;
    }

}
