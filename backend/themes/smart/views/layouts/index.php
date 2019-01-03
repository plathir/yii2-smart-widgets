<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use \yii\helpers\ArrayHelper;
use plathir\widgets\common\helpers\LayoutHelper;
?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('widgets', 'List of Layouts') ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= Html::a(Yii::t('widgets', 'Create new Layout'), ['create'], ['class' => 'btn btn-success']) ?>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'tech_name',
                    'value' => function($model) {
                        $helper = new LayoutHelper();
                        $val = $model->tech_name;
                        $positions = $helper->FindPositions($model->html_layout);
                        $val_positions = Yii::t('widgets', '<br><i><u>Positions </u>: </i>');
                        foreach ($positions as $position) {
                            if ($position == 'CONTENT') {
                                $val_positions .= '<br><span class="label label-primary">' . $position . '</span>';
                            } else {
                                $val_positions .= '<br>' . Html::a('<span class="label label-primary">' . $position . '</span>', ['/widgets/positions/view', 'tech_name' => $position]);
                            }
                        }
                        return '<strong>' . $val . '</strong>' . $val_positions;
                    },
                    'format' => 'raw',
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
                                        'data-confirm' => Yii::t('widgets', 'Delete position ! Are yoy sure ?'),
                                        'data-method' => 'post'
                            ]);
                        },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                            $url = Url::to(['layouts/view', 'tech_name' => $model->tech_name]);
                            return $url;
                        }
                        if ($action === 'update') {
                            $url = Url::to(['layouts/update', 'tech_name' => $model->tech_name]);
                            return $url;
                        }
                        if ($action === 'delete') {
                            $url = Url::to(['layouts/delete', 'tech_name' => $model->tech_name]);
                            return $url;
                        }
                    }
                ]
            ]
        ]);
        ?>


    </div>
</div>






