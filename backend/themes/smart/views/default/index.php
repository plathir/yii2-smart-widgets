<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;
?>

<div class="smartblog-default-index">
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('widgets', 'Widgets') ?></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <?= Html::a('<i class="fa fa-th-list"></i>' . Yii::t('widgets', 'Widgets Types'), ['/widgets/types'], ['class' => 'btn btn-app']) ?>
            <?= Html::a('<i class="fa fa-th-list"></i>' . Yii::t('widgets', 'Positions'), ['/widgets/positions'], ['class' => 'btn btn-app']) ?>
        </div>
    </div>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('widgets', 'List of Widgets') ?></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <?= Html::a(Yii::t('widgets', 'Create new widget'), ['create'], ['class' => 'btn btn-success']) ?>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'id',
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'min-width: 20px;'],
                        'template' => '{my_button1}',
                        'buttons' => [
                            'my_button1' => function ($url, $model, $key) {
                                return Html::a(Yii::t('widgets', '<i class="glyphicon glyphicon-search"></i>'), ['/widgets/default/preview', 'id' => $model->id]);
                            },
                        ],
                    ],
                    [
                        'attribute' => 'widget_type',
                        'value' => function($model, $key, $index, $widget) {
                            return plathir\widgets\backend\models\WidgetsTypes::findOne($model->widget_type)->widget_name;
                        },
                        'format' => 'html',
                        'filter' => Html::activeDropDownList($searchModel, 'widget_type', \yii\helpers\ArrayHelper::map(plathir\widgets\backend\models\WidgetsTypes::find()->all(), 'tech_name', 'widget_name'), ['class' => 'form-control', 'prompt' => Yii::t('widgets', 'Select...')])
                    ],
                    [
                        'attribute' => 'name',
                    ],
                    [
                        'attribute' => 'position',
                        'value' => function($model, $key, $index, $widget) {
                            return plathir\widgets\backend\models\Positions::findOne($model->position)->name;
                        },
                        'filter' => \yii\bootstrap\Html::activeDropDownList($searchModel, 'position', \yii\helpers\ArrayHelper::map(plathir\widgets\backend\models\Positions::find()->all(), 'tech_name', 'name'), ['class' => 'form-control', 'prompt' => Yii::t('widgets', 'Select...')]),
                    ],
                    [
                        'attribute' => 'publish',
                        'value' => function($model, $key, $index, $widget) {
                            return $model->publishbadge;
                        },
                        'format' => 'html',
                        'filter' => \yii\bootstrap\Html::activeDropDownList($searchModel, 'publish', ['0' => Yii::t('widgets', 'Unpublished'), '1' => Yii::t('widgets', 'Published')], ['class' => 'form-control', 'prompt' => Yii::t('widgets', 'Select...')]),
                        'contentOptions' => ['style' => 'width: 10%;']
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:'.Yii::$app->settings->getSettings('ShortDateFormat') ],
                        'value' => 'created_at',
                        'filter' =>
                        DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'created_at',
                            'options' => ['placeholder' => 'Enter date ...'],
                            'removeButton' => false,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => Yii::$app->settings->getSettings('FilterShortDateFormat'),
                            ]
                        ]),
//                        DateControl::widget([
//                            'attribute' => 'created_at',
//                            'name' => 'kartik-date-1',
//                              'value' => 'created_at',
//                            'type' => DateControl::FORMAT_DATE,
//                            'displayFormat' => 'php:d-m-Y',
//                            'saveFormat' => 'php:d-m-Y',
//                            'options' => [
//                                'layout' => '{picker}{input}',
//                            ]
//                        ]),
                        'contentOptions' => ['style' => 'width: 12%;']
                    ],
//                    [
//                        'attribute' => 'updated_at',
//                        'format' => ['date', 'php:d-m-Y'],
//                        'filter' =>
//                        DateControl::widget([
//                            'model' => $searchModel,
//                            'attribute' => 'updated_at',
//                            'name' => 'kartik-date-2',
//                            'value' => 'updated_at',
//                            'type' => DateControl::FORMAT_DATE,
//                            'options' => [
//                                'layout' => '{picker}{input}',
//                            ]
//                        ]),
//                        'contentOptions' => ['style' => 'width: 12%;']
//                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'min-width: 80px;'],
                        'template' => '{my_button}',
                        'buttons' => [
                            'my_button' => function ($url, $model, $key) {
                                return Html::a(Yii::t('widgets', 'Parameters'), ['/widgets/default/updateparams', 'id' => $model->id]);
                            },
                        ],
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'min-width: 70px;']
                    ]
                ]
            ]);
            ?>

        </div>
    </div>



</div>  