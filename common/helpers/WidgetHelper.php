<?php
namespace plathir\widgets\common\helpers;

use plathir\widgets\backend\models\Positions;
use plathir\widgets\backend\models\PositionsSortOrder;
use Yii;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class WidgetHelper {
    /*
     * Load Widget
     */

    public function LoadWidget($WidgetID) {
        $Widget = \plathir\widgets\backend\models\Widgets::findOne($WidgetID);
        if ($Widget) {
            if ($Widget->publish == 1) {
                $WdgetType = \plathir\widgets\backend\models\WidgetsTypes::findOne($Widget->widget_type);
                $widget_class = $WdgetType->widget_class;
                $tmpWidget = new $widget_class();
                $config = json_decode($Widget->config, true);
                $config["title"] = $Widget->name;
                $newWidget = $tmpWidget::widget($config);
                $widget_html = $newWidget;
                return $widget_html;
            } else {
                return '';
            }
        } else {
            //  echo $WidgetID;
        }
    }

    public function getListOfModules() {
        // Get items from frontend
        $items_frontend = array_keys(Yii::$app->modules['frontendconfig']['modules']);

        $key_h = 0;
        foreach ($items_frontend as $key => $value) {
            if ($value != 'gii' && $value != 'debug') {
                $key_h = $key_h + 1;
                $newItems[$key_h]['id'] = $key_h;
                $newItems[$key_h]['module_name'] = 'frontend-' . $value;
            }
        }

        $items = array_keys(Yii::$app->modules);
        foreach ($items as $key => $value) {
            if ($value != 'frontendconfig' && $value != 'gii' && $value != 'debug') {
                $key_h = $key_h + 1;
                $newItems[$key_h]['id'] = $key_h;
                $newItems[$key_h]['module_name'] = 'backend-' . $value;
            }
        }
        return $newItems;
    }

}
