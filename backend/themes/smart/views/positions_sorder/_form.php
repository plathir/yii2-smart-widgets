<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\sortinput\SortableInput;
?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>

    </div><!-- /.box-header -->
    <div class="box-body">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'name' => 'UpdPositions']]); ?>
        <?php
        $array_items = (explode(',', $model->widget_sort_order));
        $widgeHelper = new plathir\widgets\common\helpers\WidgetHelper();
        $style = '#opacity-div {
                  opacity: 0.8;
                  filter : alpha(opacity=80); 
                  zoom:0.7
                 }';

        $this->registerCss($style);

        foreach ($array_items as $item) {
            // in this place find description of widget
            // ...
            $widget = plathir\widgets\backend\models\Widgets::findOne($item);
            $newarray[$item]['content'] = '<div style="max-height:200px;overflow:hidden; "> <strong>' . $item . '. ' . $widget->name . '</strong>' . $widget->publishbadge . '<br>' . '<div id="opacity-div">' . $widgeHelper->LoadWidget($widget) . '</div></div>';
        }

        echo SortableInput::widget([
            'model' => $model,
            'attribute' => 'widget_sort_order',
            'hideInput' => true,
            'delimiter' => ',',
            'items' => $newarray,
        ]);
        ?> 

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>' . Yii::t('widgets', ' Create') : '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>' . Yii::t('widgets', ' Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>     

    </div>
</div>