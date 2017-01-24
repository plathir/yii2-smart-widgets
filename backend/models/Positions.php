<?php

namespace plathir\widgets\backend\models;

use yii;

class Positions extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%widgets_positions}}';
    }

    public function rules() {
        return [
            [['name', 'module_name'], 'required'],
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
            'environment' => Yii::t('app', 'Environment'),
            'module_name' => Yii::t('app', 'Module Name'),
            'publishbadge' => Yii::t('app', 'Publish'),
        ];
    }

    public function getModuleslist() {

        $newItems = \plathir\widgets\common\helpers\WidgetHelper::getListOfModules();

        return $newItems;
    }

    public function getEnvironment() {
        if ($this->module_name) {
            $h_env = explode('-', $this->module_name);
            if ($h_env) {
                return $h_env[0];
            }
        }
    }

    public function getPublishbadge() {
        $badge = '';
        switch ($this->publish) {
            case 0:
                $badge = '<span class="label label-danger">Unpublished</span>';
                break;
            case 1:
                $badge = '<span class="label label-success">Published</span>';
                break;
            default:
                break;
        }

        return $badge;
    }
    
        public function getWidgets() {
        return $this->hasMany(Widgets::className(), ['position' => 'id']);
    }


}
