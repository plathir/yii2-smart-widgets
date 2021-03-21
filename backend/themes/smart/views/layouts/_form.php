<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use lav45\aceEditor\AceEditorWidget;
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
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <?php
            if ($model->moduleslist) {
                $newItems = \yii\helpers\ArrayHelper::map($model->moduleslist, 'module_name', 'module_name');
            } else {
                $newItems = '';
            }
            ?>

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'name' => 'UpdLayouts']]); ?>
            <?php
            echo $form->field($model, 'tech_name');
            echo $form->field($model, 'name');
            echo $form->field($model, 'path');
            //echo $model->fullpath;

            // echo $form->field($model, 'html_layout')->textarea(['rows' => 6]);
            echo $form->field($model, 'html_layout')->widget(AceEditorWidget::className(), [
                //'theme' => 'xcode',
                //  'theme' => 'twilight', // dark theme
                'mode' => 'html',
                'showPrintMargin' => false,
                'fontSize' => 14,
                'height' => 300,
                'options' => [
                    'style' => 'border: 1px solid #ccc; border-radius: 4px;'
                ]
            ]);

            echo $form->field($model, 'module_name')->dropDownList($newItems);
            echo $form->field($model, 'publish')->widget(SwitchInput::classname(), []);
            
            ?> 

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> ' . Yii::t('widgets', 'Save') : '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> ' . Yii::t('widgets', 'Save Changes'), ['class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-primary btn-flat']) ?>
            </div>

            <?php ActiveForm::end(); ?>   
        </div>     
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <h4><?= Yii::t('widgets','Available Positions') ?></h4>
            <hr>
            <table>
                <?php
                foreach ($positions as $position) {
                   $position_link =  Html::a($position->name, ['/widgets/positions/view', 'tech_name' => $position->tech_name]);
                    echo '<tr>';
                    echo '<td>{' . $position->tech_name . '}</td><td>' . $position_link . '</td>';
                    echo '</tr>';
                };
                ?>
            </table>
        </div>
    </div>
</div>
