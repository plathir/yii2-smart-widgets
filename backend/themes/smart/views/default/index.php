<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>
<?php
//echo Html::tag('span', 'tooltip', [
//    'title' => 'This is a test tooltip',
//    'data-toggle' => 'tooltip',
//]);
?>
<div class="smartblog-default-index">


    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('widgets', 'List of Widgets') ?></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <?=
            Html::a(Html::tag('span', 'Create', [
                        'title' => Yii::t('widgets', 'Create New Widget'),
                        'data-toggle' => 'tooltip',
                    ]), ['create'], ['class' => 'btn btn-success btn-flat btn-loader'])
            ?>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'id',
                        'contentOptions' => ['style' => 'width: 60px;'],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'min-width: 20px;'],
                        'template' => '{my_button1}',
                        'buttons' => [
                            'my_button1' => function ($url, $model, $key) {
                                return Html::a(Html::tag('span', '<i class="glyphicon glyphicon-search btn-loader"></i>', [
                                                    'title' => Yii::t('widgets', 'Preview'),
                                                    'data-toggle' => 'tooltip',
                                                ]), ['/widgets/default/preview', 'id' => $model->id]);
                            },
                        ],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'min-width: 20px;'],
                        'template' => '{my_button}',
                        'buttons' => [
                            'my_button' => function ($url, $model, $key) {
                                return Html::a(Html::tag('span', '<i class="fa fa-cog btn-loader"></i>', [
                                                    'title' => Yii::t('widgets', 'Edit Parameters'),
                                                    'data-toggle' => 'tooltip',
                                                ]), ['/widgets/default/updateparams', 'id' => $model->id]);
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
                        'format' => ['date', 'php:' . Yii::$app->settings->getSettings('ShortDateFormat')],
                        'value' => 'created_at',
                        'filter' => \backend\widgets\SmartDate::widget(['type' => 'filterShortDate', 'model' => $searchModel, 'attribute' => 'created_at']),
                        'contentOptions' => ['style' => 'width: 12%;']
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => ['date', 'php:' . Yii::$app->settings->getSettings('ShortDateFormat')],
                        'value' => 'updated_at',
                        'filter' => \backend\widgets\SmartDate::widget(['type' => 'filterShortDate', 'model' => $searchModel, 'attribute' => 'updated_at']),
                        'contentOptions' => ['style' => 'width: 12%;']
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'min-width: 70px;',
                            'class'=> 'btn-loader',
                            ]
                    ]
                ]
            ]);
            ?>

        </div>
    </div>



</div>  