<?php

namespace plathir\widgets\common\helpers;

use plathir\widgets\backend\models\Positions;
use plathir\widgets\backend\models\Widgets;
use plathir\widgets\common\helpers\WidgetHelper;
use plathir\widgets\backend\models\PositionsSortOrder;
use yii;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PositionHelper {
    /*
     * Load Position
     */

    public function LoadPosition($PositionTechName, $display_position = false) {
        $display_position = Yii::$app->getRequest()->getQueryParam('display_position');
        $position = Positions::findOne(['tech_name'=> $PositionTechName]);
        $widgetHelper = new WidgetHelper();

        if ($position && $position->publish == 1) {
            $PositionTechName = $position->tech_name;
            // Display Position name before displays widgets
            if ($display_position === 'true') {
                $html_widget = $position->name;
            } else {
                $html_widget = '';
            }

            $sort_order = PositionsSortOrder::findOne($PositionTechName);
            if ($sort_order) {
                $widgets_array = explode(',', $sort_order->widget_sort_order);

                foreach ($widgets_array as $widget) {

                    $html_widget .= $widgetHelper->LoadWidget($widget);
                }

                return $html_widget;
            } else {
                return 'No Sort Order';
            }
        }
    }

    public function BuildPosition($position_tech_name) {
        $PositionWidgets = Widgets::find()->where('position = :tech_name', ['tech_name' => $position_tech_name])->all();

        $position = PositionsSortOrder::findOne($position_tech_name);
        if (!$position) {
            $position = new PositionsSortOrder();
            $position->position_tech_name = $position_tech_name;
            $PositionSortOrder = [];
        } else {
            if ($position->widget_sort_order) {
                $PositionSortOrder = explode(",", $position->widget_sort_order);
            } else {
                $PositionSortOrder = [];
            }
        }
        print_r($PositionSortOrder);

        foreach ($PositionWidgets as $widget) {
            echo $widget->id;
            $index = array_search($widget->id, $PositionSortOrder);

            if ($index !== false) {
                echo 'Found <br>';
            } else {
                echo 'Not Found  ! add to array <br>';
                $PositionSortOrder[] = $widget->id;
            }
        }

        foreach ($PositionSortOrder as $temp_widget_id) {
            $temp_widget = Widgets::findOne($temp_widget_id);
            if (!$temp_widget) {
                $PositionSortOrder = PositionHelper::my_remove_array_item($PositionSortOrder, $temp_widget_id);
            } else {

                if ($temp_widget->position <> $position_tech_name) {
                    echo 'In';
                    $PositionSortOrder = PositionHelper::my_remove_array_item($PositionSortOrder, $temp_widget_id);
                }
            }
        }
        if ($PositionSortOrder == null) {
            $position->delete();
        } else {
            $position->widget_sort_order = implode(",", $PositionSortOrder);
            $position->save();
        }
    }

    public function RemoveWidgetFromPosition($position_id, $widget_id) {
        // echo 'Remove ' . $widget_id . ' From position ' . $position_id;
        $position = PositionsSortOrder::findOne($position_id);
        if ($position) {

            $PositionSortOrder = explode(",", $position->widget_sort_order);
            print_r($PositionSortOrder);
            $PositionSortOrder = PositionHelper::my_remove_array_item($PositionSortOrder, $widget_id);

            if ($PositionSortOrder == null) {
                $position->delete();
            } else {
                $position->widget_sort_order = implode(",", $PositionSortOrder);
                $position->save();
            }
        }
    }

    public function my_remove_array_item($array, $item) {
        $index = array_search($item, $array);
        if ($index !== false) {
            unset($array[$index]);
        }

        return $array;
    }

}
