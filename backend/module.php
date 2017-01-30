<?php

namespace plathir\widgets\backend;

use Yii;

class Module extends \yii\base\Module {

    public $Theme = 'smart';

    public function init() {
        $path = Yii::getAlias('@vendor') . '/plathir/yii2-smart-widgets/backend/themes/' . $this->Theme . '/views';
        $this->setViewPath($path);

        parent::init();
    }

}
