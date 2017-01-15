<?php

namespace plathir\widgets\backend\models;

use yii;

class Positions extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%widgets_positions}}';
    }
    
    
        public function rules() {
        return [
            [['name', 'module_name' ], 'required'],
            [['publish'], 'integer']
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'Position ID'),
            'name' => Yii::t('app', 'Name'),
            'publish' => Yii::t('app', 'Publish'),
            'module_name' => Yii::t('app', 'Module Name'),
        ];
    }


}
