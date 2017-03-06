<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use \yii\helpers\ArrayHelper;
?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('widgets', 'List of Widgets Types') ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= Html::a(Yii::t('widgets','Create new Type'), ['create'], ['class' => 'btn btn-success']) ?>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [

                [
                    'attribute' => 'tech_name',
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
                    'attribute' => 'widget_name',
                ],
                [
                    'attribute' => 'widget_class',
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}{delete}',
                    'contentOptions' => ['style' => 'min-width: 80px;'],
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp;', $url, [
                                        'title' => Yii::t('widgets', 'view'),
                            ]);
                        },
                        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>&nbsp;', $url, [
                                        'title' => Yii::t('widgets', 'view'),
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>&nbsp;', $url, [
                                        'title' => Yii::t('widgets', 'delete'),
                                        'data-confirm' => Yii::t('widgets', 'Delete type ! Are yoy sure ?'),
                                        'data-method' => 'post'
                            ]);
                        },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                            $url = Url::to(['types/view', 'tech_name' => $model->tech_name]);
                            return $url;
                        }
                        if ($action === 'update') {
                            $url = Url::to(['types/update', 'tech_name' => $model->tech_name]);
                            return $url;
                        }
                        if ($action === 'delete') {
                            $url = Url::to(['types/delete', 'tech_name' => $model->tech_name]);
                            return $url;
                        }
                    }
                ]
            ]
        ]);
        ?>


    </div>
</div>






