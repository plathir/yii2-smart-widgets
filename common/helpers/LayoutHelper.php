<?php
namespace plathir\widgets\common\helpers;

use plathir\widgets\backend\models\search\Layouts_s;
use plathir\widgets\backend\models\Layouts;
use plathir\widgets\backend\models\Positions;
use plathir\widgets\common\helpers\PositionHelper;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LayoutHelper {
    /*
     * Load Layout
     */

    public function LoadLayout($fname, $content = '') {
        $layouts = Layouts::find()->All();
        foreach ($layouts as $layout) {
            if ($layout->fullpath == $fname && $layout->publish == true) {
                $positions = $this->FindPositions($layout->html_layout);
                $full_html_layout = $layout->html_layout;
                foreach ($positions as $position) {

                    if ($position == 'CONTENT') {
                        $full_html_layout = str_replace('{CONTENT}', $content, $full_html_layout);
                    } else {
                        $position_var = '{' . $position . '}';
                        $position_html = $this->MakePosiitonHTML($position);
                        $full_html_layout = str_replace($position_var, $position_html, $full_html_layout);
                    }
                }
                
                return $full_html_layout;
            }
        }
    }

    public function FindPositions($layout) {
        preg_match_all('/{(.*?)}/s', $layout, $matches);
        return $matches[1];
    }

    public function MakePosiitonHTML($position) {
        if ($this->CheckPositionExist($position) == true) {
            $helper = new PositionHelper();
            return $helper->LoadPosition($position);
        }
    }

    public function CheckPositionExist($position) {
        $position_model = Positions::findOne(['tech_name' => $position]);
        if ($position_model) {
            return true;
        } else {
            return false;
        }
    }

}
