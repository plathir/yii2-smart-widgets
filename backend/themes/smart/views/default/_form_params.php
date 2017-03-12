<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
        $widgets_types_Model = new plathir\widgets\backend\models\WidgetsTypes();
        $items = \yii\helpers\ArrayHelper::map($widgets_types_Model::find()->all(), 'tech_name', 'widget_name');
        ?>   

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'name' => 'UpdTypes']]); ?>
        <?php
        foreach ($model->selection_parameters as $i => $param) {
            echo $form->field($model, "selection_parameters[$i]")->textInput(['value' => $param])->label($i);
        }
        ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>' . Yii::t('widgets', ' Create') : '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>' . Yii::t('widgets', ' Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>     

    </div>
</div>
