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
            [['tech_name'], 'required' ],
            [['tech_name'], 'unique' ],
            
            [['module_name', 'widget_name', 'widget_class','description'], 'required'],
            ['widget_class',
                function ($attribute, $params) {
                    if (!class_exists($this->$attribute)) {
                        $this->addError($attribute, Yii::t('widgets','Class {class} cannot exist', [ 'class' => $this->$attribute]));
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
            'id' => Yii::t('widgets', 'Widget Type ID'),
            'module_name' => Yii::t('widgets', 'Module Name'),
            'widget_name' => Yii::t('widgets', 'Widget Name'),
            'widget_class' => Yii::t('widgets', 'Widget class'),
            'description' => Yii::t('widgets', 'Description'),
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
