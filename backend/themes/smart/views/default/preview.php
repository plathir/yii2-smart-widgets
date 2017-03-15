<?php
use plathir\widgets\common\helpers\WidgetHelper;


$myWidget = new WidgetHelper();


 echo 'Preview Widget :'. $widget_id;
 
 echo $myWidget->LoadWidget($widget_id);