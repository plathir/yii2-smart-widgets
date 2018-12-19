<?php
namespace plathir\widgets\common\helpers;

use plathir\widgets\backend\models\search\Layouts_s;
use plathir\widgets\backend\models\Layouts;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LayoutHelper {
    /*
     * Load Layout
     */

    public function LoadLayout($fname) {
        $layouts = Layouts::find()->All();
        foreach ($layouts as $layout) {
            if ($layout->fullpath == $fname) {
                $this->FindParameters($layout->html_layout);
                return $layout->html_layout;
            }
        };
    }

    public function FindParameters($layout) {
        preg_match_all('/{(.*?)}/s', $layout, $matches);
        return $matches[1];
    }

}
