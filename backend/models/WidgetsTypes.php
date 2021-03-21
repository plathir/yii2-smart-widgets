<?php
namespace plathir\widgets\backend\models;

use yii;
use \plathir\widgets\common\helpers\WidgetHelper;
use \plathir\apps\backend\models\Apps;

class WidgetsTypes extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%widgets_types}}';
    }

    public function rules() {
        return [
            [['tech_name'], 'required'],
            [['tech_name'], 'unique'],
            [['module_name', 'widget_name', 'widget_class', 'description'], 'required'],
            ['widget_class',
                function ($attribute, $params) {
                    if (!class_exists($this->$attribute)) {
                        $this->addError($attribute, Yii::t('widgets', 'Class {class} cannot exist', ['class' => $this->$attribute]));
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
            'tech_name' => Yii::t('widgets', 'Widget Technical Name'),
            'module_name' => Yii::t('widgets', 'Module Name'),
            'widget_name' => Yii::t('widgets', 'Widget Name'),
            'widget_class' => Yii::t('widgets', 'Widget class'),
            'description' => Yii::t('widgets', 'Description'),
            'environment' => Yii::t('widgets', 'Environment'),
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
        return $this->hasMany(Widgets::className(), ['widget_type' => 'tech_name']);
    }

    public function getApp() {
        $h_name = '';
        if ($this->module_name) {
            $h_name_array = explode('-', $this->module_name);
            if ($h_name_array) {
                $h_name = $h_name_array[1];
                $app = Apps::findOne(['name' => $h_name]);
                if ($app) {
//                    echo $h_name;
//                  //  print_r($app);
//                    die();
                    return $app;
                }
            }
        }
    }

}
