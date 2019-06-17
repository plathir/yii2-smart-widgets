<?php
namespace plathir\widgets\backend;

use Yii;
use \common\helpers\ThemesHelper;

class Module extends \yii\base\Module {

    public $Theme = 'smart';

    public function init() {      
        
        $helper = new ThemesHelper();
        $path = $helper->ModuleThemePath('widgets', 'backend', dirname(__FILE__) . "/themes/$this->Theme");
        $path = $path . '/views';
        
        $this->setViewPath($path);
        parent::init();
        $this->registerTranslations();
    }

    public function registerTranslations() {
        /*         * This registers translations for the widgets module * */
        Yii::$app->i18n->translations['widgets'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => Yii::getAlias('@vendor/plathir/yii2-smart-widgets/backend/messages'),
        ];
    }

}
