<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\ArrayHelper;
?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('widgets', 'List of Positions') ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= Html::a(Yii::t('widgets', 'Create new Position'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('widgets', 'Rebuild Sort Order'), ['rebuild'], ['class' => 'btn btn-success']) ?>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'id',
                ],
                [
                    'attribute' => 'name',
                ],
                [
                    'attribute' => 'environment',
                    'format' => 'html',
                    'filter' => Html::activeDropDownList($searchModel, 'environment', ['backend' => 'backend', 'frontend' => 'frontend'], ['class' => 'form-control', 'prompt' => Yii::t('widgets', 'Select...')])
                ],
                [
                    'attribute' => 'module_name',
                    'format' => 'html',
                    'filter' => Html::activeDropDownList($searchModel, 'module_name', ArrayHelper::map($searchModel->moduleslist, 'module_name', 'module_name'), ['class' => 'form-control', 'prompt' => Yii::t('widgets', 'Select...')])
                ],
                [
                    'attribute' => 'publish',
                    'value' => function($model, $key, $index, $widget) {
                        return $model->publishbadge;
                        //  return $model->publish == true ? '<span class="label label-success">Published</span>' : '<span class="label label-danger">Unpublished</span>';
                    },
                    'format' => 'html',
                    'filter' => \yii\bootstrap\Html::activeDropDownList($searchModel, 'publish', ['0' => Yii::t('widgets', 'Unpublished'), '1' => Yii::t('widgets', 'Published')], ['class' => 'form-control', 'prompt' => Yii::t('widgets', 'Select...')]),
                    'contentOptions' => ['style' => 'width: 10%;']
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'min-width: 80px;'],
                    'template' => '{my_button}',
                    'buttons' => [
                        'my_button' => function ($url, $model, $key) {
                            return Html::a(Yii::t('widgets', 'Sort Order'), ['positions_sorder/update', 'id' => $model->id]);
                        },
                    ],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{my_button}',
                    'buttons' => [
                        'my_button' => function ($url, $model, $key) {
                            return Html::a(Yii::t('widgets', 'Rebuild'), ['rebuildposition', 'position_id' => $model->id]);
                        },
                    ]
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'min-width: 70px;']
                ]
            ]
        ]);
        ?>


    </div>
</div>






