<?php

namespace plathir\widgets\backend\models;

use yii;
use \plathir\widgets\common\helpers\WidgetHelper;

class Positions extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%widgets_positions}}';
    }

    public function rules() {
        return [
            [['tech_name'], 'unique'],
            [['tech_name'], 'required' ],
            [['name', 'module_name'], 'required'],
            [['publish'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('widgets', 'Position ID'),
            'name' => Yii::t('widgets', 'Name'),
            'publish' => Yii::t('widgets', 'Publish'),
            'environment' => Yii::t('widgets', 'Environment'),
            'module_name' => Yii::t('widgets', 'Module Name'),
            'publishbadge' => Yii::t('widgets', 'Publish'),
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

    public function getPublishbadge() {
        $badge = '';
        switch ($this->publish) {
            case 0:
                $badge = '<span class="label label-danger">' . Yii::t('widgets', 'Unpublished') . '</span>';
                break;
            case 1:
                $badge = '<span class="label label-success">' . Yii::t('widgets', 'Published') . '</span>';
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
