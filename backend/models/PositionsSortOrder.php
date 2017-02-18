<?php

namespace plathir\widgets\backend\models;

use yii;

class PositionsSortOrder extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%widgets_positions_sorder}}';
    }
    
    
        public function rules() {
        return [
            [['position_id','widget_sort_order'], 'required'],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'position_id' => Yii::t('widgets', 'Position ID'),
            'widget_sort_order' => Yii::t('widgets', 'Widget Sort Order'),
        ];
    }


}
