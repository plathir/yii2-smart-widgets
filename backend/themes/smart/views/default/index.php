<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
?>
<div class="smartblog-default-index">
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Widgets</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <?= Html::a(Yii::t('app', '<i class="fa fa-th-list"></i>Widgets Types'), ['/widgets/types'], ['class' => 'btn btn-app']) ?>
            <?= Html::a(Yii::t('app', '<i class="fa fa-th-list"></i>Positions'), ['/widgets/positions'], ['class' => 'btn btn-app']) ?>
        </div>
    </div>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">List of Widgets</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <?= Html::a('Create new widget', ['create'], ['class' => 'btn btn-success']) ?>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [

                    [
                        'attribute' => 'id',
                    ],
                    [
                        'attribute' => 'widget_type',
                        'value' => function($model, $key, $index, $widget) {
                            return plathir\widgets\backend\models\WidgetsTypes::findOne($model->widget_type)->widget_name;
                        },
                        'format' => 'html',
                        'filter' => Html::activeDropDownList($searchModel, 'widget_type', \yii\helpers\ArrayHelper::map(plathir\widgets\backend\models\WidgetsTypes::find()->all(), 'id', 'widget_name'), ['class' => 'form-control', 'prompt' => 'Select...'])
                    ],
                    [
                        'attribute' => 'name',
                    ],
                    [
                        'attribute' => 'description',
                    ],
                    [
                        'attribute' => 'position',
                            'value' => function($model, $key, $index, $widget) {
                            return plathir\widgets\backend\models\Positions::findOne($model->position)->name;
                        },

                        'filter' => \yii\bootstrap\Html::activeDropDownList($searchModel, 'position', \yii\helpers\ArrayHelper::map(plathir\widgets\backend\models\Positions::find()->all(), 'id', 'name'), ['class' => 'form-control', 'prompt' => 'Select...']),
                       
                    ],
                    [
                        'attribute' => 'publish',
                        'value' => function($model, $key, $index, $widget) {
                            return $model->publish == true ? '<span class="label label-success">Published</span>' : '<span class="label label-danger">Unpublished</span>';
                        },
                        'format' => 'html',
                        'filter' => \yii\bootstrap\Html::activeDropDownList($searchModel, 'publish', ['0' => 'Unpublished', '1' => 'Published'], ['class' => 'form-control', 'prompt' => 'Select...']),
                        'contentOptions' => ['style' => 'width: 10%;']
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:d-m-Y'],
                        'filter' =>
                        DateControl::widget([
                            'model' => $searchModel,
                            'attribute' => 'created_at',
                            'name' => 'kartik-date-1',
                            'value' => 'created_at',
                            'type' => DateControl::FORMAT_DATE,
                            'options' => [
                                'layout' => '{picker}{input}',
                            ]
                        ]),
                        'contentOptions' => ['style' => 'width: 12%;']
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => ['date', 'php:d-m-Y'],
                        'filter' =>
                        DateControl::widget([
                            'model' => $searchModel,
                            'attribute' => 'created_at',
                            'name' => 'kartik-date-2',
                            'value' => 'created_at',
                            'type' => DateControl::FORMAT_DATE,
                            'options' => [
                                'layout' => '{picker}{input}',
                            ]
                        ]),
                        'contentOptions' => ['style' => 'width: 12%;']
                    ],
                    ['class' => 'yii\grid\ActionColumn']
                ]
            ]);
            ?>

        </div>
    </div>



</div>  