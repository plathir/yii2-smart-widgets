<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
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

        <?php
        if ($model->moduleslist) {
            $newItems = \yii\helpers\ArrayHelper::map($model->moduleslist, 'module_name', 'module_name');
        } else {
            $newItems = '';
        }
        ?>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'name' => 'UpdPositions']]); ?>
        <?php
        echo $form->field($model, 'tech_name');
        echo $form->field($model, 'name');
        echo $form->field($model, 'module_name')->dropDownList($newItems);
        echo $form->field($model, 'publish')->widget(SwitchInput::classname(), []);
        ?> 

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Create' : '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>     

    </div>
</div>