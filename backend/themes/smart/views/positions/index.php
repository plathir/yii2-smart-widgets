<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use \yii\helpers\ArrayHelper;
use yii\web\View;
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
        <?= Html::a('<i class="fa fa-fw fa-plus"></i> '.Yii::t('widgets', 'Create new Position'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
        <?= Html::a('<i class="fa fa-fw fa-cubes"></i> '.Yii::t('widgets', 'Rebuild Sort Order'), ['rebuild'], ['class' => 'btn btn-success btn-flat']) ?>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'tech_name',
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
                    'contentOptions' => ['style' => 'min-width: 30px;'],
                    'template' => '{my_button}',
                    'buttons' => [
                        'my_button' => function ($url, $model, $key) {
                            return Html::a('<i class="fa fa-fw fa-list-ol"></i>', ['positions_sorder/update', 'tech_name' => $model->tech_name], [
                              'title' => Yii::t('widgets', 'Sort Order')  
                            ]);
//                            return Html::a('<i class="fa fa-fw fa-list-ol" rel="tooltip" title="' . Yii::t('widgets', 'Sort Order') . '" ></i>', ['positions_sorder/update', 'tech_name' => $model->tech_name]);
                            //return Html::a('<i class="fa fa-fw fa-list-ol" rel="tooltip" title="' . Yii::t('widgets', 'Sort Order') . '" ></i>', ['positions_sorder/update', 'tech_name' => $model->tech_name], [
//                                'title' => Yii::t('widgets', 'Sort Order'),
//                            ]);
                        },
                    ],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{my_button}',
                    'buttons' => [
                        'my_button' => function ($url, $model, $key) {
                            return Html::a('<i class="fa fa-fw fa-cubes"></i>', ['rebuildposition', 'tech_name' => $model->tech_name],[
                                'title' => Yii::t('widgets', 'Rebuild'),
                            ] );
                        },
                    ]
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}{delete}',
                    'contentOptions' => ['style' => 'min-width: 80px;'],
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp;', $url, [
                                        'title' => Yii::t('widgets', 'View'),
                            ]);
                        },
                        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>&nbsp;', $url, [
                                        'title' => Yii::t('widgets', 'Update'),
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>&nbsp;', $url, [
                                        'title' => Yii::t('widgets', 'Delete'),
                                        'data-confirm' => Yii::t('widgets', 'Delete position ! Are yoy sure ?'),
                                        'data-method' => 'post'
                            ]);
                        },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                            $url = Url::to(['positions/view', 'tech_name' => $model->tech_name]);
                            return $url;
                        }
                        if ($action === 'update') {
                            $url = Url::to(['positions/update', 'tech_name' => $model->tech_name]);
                            return $url;
                        }
                        if ($action === 'delete') {
                            $url = Url::to(['positions/delete', 'tech_name' => $model->tech_name]);
                            return $url;
                        }
                    }
                ]
            ]
        ]);
        ?>

        <?php
//        $js = "$(document).ready(function () {
//                $('[rel=tooltip]').tooltip({placement: 'top'});
//            });";
//
//        $this->registerJs(
//                $js, View::POS_READY
//        );
        ?>
    </div>
</div>






