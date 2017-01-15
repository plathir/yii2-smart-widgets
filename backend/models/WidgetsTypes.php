<?php

namespace plathir\widgets\backend\models;
use yii;

class WidgetsTypes extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%widgets_types}}';
    }
    
    
        public function rules() {
        return [
            [['module_name', 'widget_name', 'widget_class', 'description'], 'required'],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'Widget Type ID'),
            'module_name' => Yii::t('app', 'Module Name'),
            'widget_name' => Yii::t('app', 'Widget Name'),
            'widget_class' => Yii::t('app', 'Widget class'),
            'description' => Yii::t('app', 'Description'),
        ];
    }


}
