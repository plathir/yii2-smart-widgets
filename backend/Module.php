<?php
namespace plathir\widgets\backend;

use Yii;

class Module extends \yii\base\Module {

    public $Theme = 'smart';

    public function init() {
//        $path = Yii::getAlias('@vendor') . '/plathir/yii2-smart-widgets/backend/themes/' . $this->Theme . '/views';
        
        if (Yii::$app->settings->getSettings('BackendTheme') != null) {
            $path = Yii::getAlias('@realAppPath') . '/themes/admin/' . Yii::$app->settings->getSettings('BackendTheme') . '/module/widgets/views';
        } else {
            $path = Yii::getAlias('@vendor') . '/plathir/yii2-smart-widgets/backend/themes/' . $this->Theme . '/views';
        }         
        
        
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
