<?php

namespace plathir\widgets\backend\models;

use yii;
use \plathir\widgets\common\helpers\WidgetHelper;

class WidgetsTypes extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%widgets_types}}';
    }

    public function rules() {
        return [
            [['module_name', 'widget_name', 'widget_class','description'], 'required'],
            ['widget_class',
                function ($attribute, $params) {
                    if (!class_exists($this->$attribute)) {
                        $this->addError($attribute, 'Class cannot exist');
                    }
                }
            ],
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

    public function getModuleslist() {
        $widgetHelper = new WidgetHelper();
        $newItems = $widgetHelper->getListOfModules();
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

    public function getWidgets() {
        return $this->hasMany(Widgets::className(), ['widget_type' => 'id']);
    }

}
