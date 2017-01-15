<?php

namespace plathir\widgets\common\helpers;

use plathir\widgets\backend\models\Positions;
use plathir\widgets\backend\models\PositionsSortOrder;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class WidgetHelper {
    /*
     * Load Position
     */

    public function LoadWidget($WidgetID) {
        $Widget = \plathir\widgets\backend\models\widgets::findOne($WidgetID);
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
    }

}
