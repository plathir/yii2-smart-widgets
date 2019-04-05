<?php
namespace plathir\widgets\backend\models;

use yii;
use \plathir\widgets\common\helpers\WidgetHelper;
use \plathir\widgets\common\helpers\LayoutHelper;
use yii\helpers\BaseFileHelper;

class Layouts extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%widgets_layouts}}';
    }

    public function rules() {
        return [
            [['tech_name'], 'unique'],
            [['tech_name'], 'required'],
            [['name', 'module_name'], 'required'],
            [['html_layout'], 'required'],
            [['path'], 'required'],
            [['publish'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
//    public function attributeLabels() {
//        return [
//            'tech_name' => Yii::t('widgets', 'Layout Technical Name'),
//            'name' => Yii::t('widgets', 'Name'),
//            'publish' => Yii::t('widgets', 'Publish'),
//            'environment' => Yii::t('widgets', 'Environment'),
//            'module_name' => Yii::t('widgets', 'Module Name'),
//            'publishbadge' => Yii::t('widgets', 'Publish'),
//        ];
//    }

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

    public function getFullpath() {
        return BaseFileHelper::normalizePath(yii::getAlias($this->path));
    }

    public function getPositions() {
     $helper = new LayoutHelper();
     return $helper->FindPositions($this->html_layout);
    }
}
