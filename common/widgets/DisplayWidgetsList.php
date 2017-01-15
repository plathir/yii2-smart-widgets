<?php

namespace plathir\widgets\common\widgets;

use yii\base\Widget;
use plathir\widgets\common\models\Widget as myWidget;

class DisplayWidgetsList extends Widget {

    public $position_id;

    public function init() {
        parent::init();
    }

    public function run() {
        $this->registerClientAssets();
        $page = $this->findModel($this->position_id);
        return $this->render('widgets_list', [
                    'widget' => $this,
                    'model' => $page
        ]);
    }

    public function registerClientAssets() {
        $view = $this->getView();
        $assets = Asset::register($view);
    }

    protected function findModel($id) {
        if (($model = myWidget::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
