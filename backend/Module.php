<?php

namespace plathir\widgets\backend;

use Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'plathir\widgets\backend\controllers';
    public $Theme = 'default';

    public function init() {

        parent::init();
            $path = Yii::getAlias('@vendor') . '/plathir/yii2-smart-widgets/backend/themes/'.$this->Theme.'/views';
           
        $this->setViewPath($path);
        

        $this->setModules([
            'settings' => [
                'class' => 'plathir\settings\Module',
                'modulename' => 'widgets'
            ],
        ]);

        $this->setComponents([
            'settings' => [
                'class' => 'plathir\settings\components\Settings',
                'modulename' => 'widgets'
            ],
        ]);
      
        $this->registerAssets();
                
    }

    public function registerAssets() {
        $view = Yii::$app->getView();
        widgetsAsset::register($view);
    }

}
