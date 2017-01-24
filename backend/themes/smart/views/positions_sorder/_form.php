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

        foreach ($array_items as $item) {
            // in this place find description of widget
            // ...
            $widget = plathir\widgets\backend\models\Widgets::findOne($item);
            $newarray[$item]['content'] = '<strong>'. $item.'. '. $widget->name .'</strong>.<br>'.$widget->publishbadge;
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
            <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Create' : '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>     

    </div>
</div>