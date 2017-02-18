<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use kartik\datecontrol\DateControl;
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
//        $items = array_keys(Yii::$app->modules);
//        foreach ($items as $key => $value) {
//            $newItems[$key]['id'] = $key;
//            $newItems[$key]['module_name'] = $value;
//        }
//
//        $newItems = \yii\helpers\ArrayHelper::map($newItems, 'module_name', 'module_name');
        ?>

        <?php
        $widgets_types_Model = new plathir\widgets\backend\models\WidgetsTypes();
        $items = \yii\helpers\ArrayHelper::map($widgets_types_Model::find()->all(), 'id', 'widget_name');
        ?>   

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'name' => 'UpdTypes']]); ?>
        <?= $form->field($model, 'widget_type')->dropDownList($items) ?> 
        <?= $form->field($model, 'name'); ?> 
        <?= $form->field($model, 'description'); ?>  
        <?= $form->field($model, 'position')->dropDownList(\yii\helpers\ArrayHelper::map(plathir\widgets\backend\models\Positions::find()->all(), 'id', 'name')); ?>  
        <?= $form->field($model, 'publish')->widget(SwitchInput::classname(), []); ?>
        <?= $form->field($model, 'config')->textarea(['rows' => 10]); ?>
        <?= $form->field($model, 'rules')->textarea(['rows' => 4]); ?>

        <?php
        echo $form->field($model, 'created_at')->widget(DateControl::classname(), [
            'type' => DateControl::FORMAT_DATETIME,
            'ajaxConversion' => true,
            'saveFormat' => 'php:U',
            'options' => [
                'layout' => '{picker}{input}',
                'pluginOptions' => [
                    'autoclose' => true,
                    'todayBtn' => true,
                ]
            ]
        ]);
        ?>

        <?php
        echo $form->field($model, 'updated_at')->widget(DateControl::classname(), [
            'type' => DateControl::FORMAT_DATETIME,
            'ajaxConversion' => true,
            'saveFormat' => 'php:U',
            'options' => [
                'layout' => '{picker}{input}',
                'pluginOptions' => [
                    'autoclose' => true,
                    'todayBtn' => true,
                ]
            ]
        ]);
        ?>        

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>'. Yii::t('widgets', ' Create' ) : '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>'. Yii::t('widgets', ' Update' ) , ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>     

    </div>
</div>