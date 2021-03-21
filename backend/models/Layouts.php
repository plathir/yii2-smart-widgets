<?php

namespace plathir\widgets\backend\models;

use yii;
use \plathir\widgets\common\helpers\WidgetHelper;
use \plathir\widgets\common\helpers\LayoutHelper;
use yii\helpers\BaseFileHelper;
use yii\web\NotFoundHttpException;
use \common\helpers\ThemesHelper;

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
    public function attributeLabels() {
        return [
            'tech_name' => Yii::t('widgets', 'Technical Name'),
            'name' => Yii::t('widgets', 'Name'),
            'publish' => Yii::t('widgets', 'Publish'),
            'environment' => Yii::t('widgets', 'Environment'),
            'module_name' => Yii::t('widgets', 'Module Name'),
            'publishbadge' => Yii::t('widgets', 'Publish'),
            'html_layout' => Yii::t('widgets', 'Html Layout'),
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

    public function getPositions() {
        $helper = new LayoutHelper();
        return $helper->FindPositions($this->html_layout);
    }

    public function getRealmodulename() {
        $temp = explode('-', $this->module_name);
        $real_module_name = '';

        if ($temp) {
            switch ($temp[1]) {
                case 'frontend_dashboard':
                    $real_module_name = 'base';
                    break;
                case 'backend_dashboard':
                    $real_module_name = 'base';
                    break;
                default:
                    $real_module_name = $temp[1];
                    break;
            }
            return $real_module_name;
        } else {
            return '';
        }
    }

    public function getThemepath() {

        $themeHelper = new ThemesHelper();

        $temp = explode('-', $this->module_name);
        $path = '';
        $real_module_name = '';

        if ($temp) {
            $module_name = $temp[1];
            switch ($module_name) {
                case 'frontend_dashboard':
                    $path = Yii::getAlias('@realAppPath') . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . 'smart';
                    $real_module_name = 'base';
                    break;
                case 'backend_dashboard':
                    $path = Yii::getAlias('@realAppPath') . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . 'smart';
                    $real_module_name = 'base';
                    break;
                default:
                    $real_module_name = $module_name;
                    break;
            }

            if ($path) {
                return $themeHelper->ModuleThemePath($real_module_name, $this->environment, realpath($path));
            } else {

                try {
                    $module = \Yii::$app->getModule($module_name);
                } catch (NotFoundHttpException $ex) {
                    $module = '';
                }
                if ($module) {
                    $path = dirname($module->getBasePath()) . DIRECTORY_SEPARATOR . $temp[0] . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . 'smart';
                    return $themeHelper->ModuleThemePath($real_module_name, $this->environment, realpath($path));
                } else {
                    return '';
                }
            }
        } else {
            return '';
        }
    }

    public function getFullpath() {
        return BaseFileHelper::normalizePath($this->themepath . $this->path);
    }

}
