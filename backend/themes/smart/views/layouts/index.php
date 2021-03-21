<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use \yii\helpers\ArrayHelper;
use plathir\widgets\common\helpers\LayoutHelper;
use yii\bootstrap\Tabs;
use \plathir\widgets\common\helpers\WidgetHelper;
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
        <?= Html::a('<i class="fa fa-fw fa-plus"></i> '.Yii::t('widgets', 'Create new Layout'), ['create'], ['class' => 'btn btn-success btn-flat btn-loader']) ?>
        <br>
        <br>
        <?php
        $widgetHelper = new WidgetHelper();
        $ListModules = $widgetHelper->getListOfModules();
        $items_frontend = [];
        $items_backend = [];

        foreach ($ListModules as $ModuleName) {
            $h_params[$ModuleName["env"]][$ModuleName["module_name"]]["Layouts_s"] = ['tech_name' => '',
                'name' => '',
                'environment' => '',
                'module_name' => $ModuleName["module_name"],
                'publish' => ''
            ];

            $grid = GridView::widget([
                        'dataProvider' => $searchModel->search($h_params[$ModuleName["env"]][$ModuleName["module_name"]]),
                        'showOnEmpty' => false,
                        'emptyText' => 'NoData',
                        'columns' => [
                            [
                                'attribute' => 'tech_name',
                                'value' => function($model) {
                                    $helper = new LayoutHelper();
                                    $val = $model->tech_name;
                                    $positions = $helper->FindPositions($model->html_layout);
                                    $val_positions = Yii::t('widgets', '<br><i><u>' . Yii::t('widgets', 'Positions') . '</u> : </i>');
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
                                'value' => function($model) {
                                    return '<h4>' . $model->name . '</h4><i><u>Path :</u> ' . $model->path . '</i>' .
                                            '<br><i><u>' . Yii::t('widgets', 'Preview') . ' :</u></i><br>' .
                                            $model->html_layout;
                                },
                                'format' => 'raw'
                            ],
                            //   'name',
                            [
                                'attribute' => 'publish',
                                'value' => function($model, $key, $index, $widget) {
                                    return $model->publishbadge;
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
                                                    'data-confirm' => Yii::t('widgets', 'Delete Layout ! Are yoy sure ?'),
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



            if (strpos($grid, 'NoData') == false) {
                if ($ModuleName["env"] == 'frontend') {
                    $items_frontend[] = ['label' => '<i class="fa fa-gear"></i>&nbsp' . $ModuleName["real_name"],
                        'content' => '<br>' . $grid,
                        'options' => ['id' => $ModuleName["module_name"]],
                    ];
                }

                if ($ModuleName["env"] == 'backend') {
                    $items_backend[] = ['label' => '<i class="fa fa-gear"></i>&nbsp' . $ModuleName["real_name"],
                        'content' => '<br>' . $grid];
                }
            }
        }
//            echo '<pre>';
//            print_r($h_params);
//            echo '</pre>';        
        ?>

        <div id="user_tabs" class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#frontend" data-toggle="tab"><i class="fa fa-tv"></i> <?= Yii::t('widgets', 'Frontend') ?></a></li>
                <li><a href="#backend" data-toggle="tab"><i class="fa fa-navicon"></i> <?= Yii::t('widgets', 'Backend') ?></a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="frontend">                    
                    <?=
                    '<h4>Modules :</h4>' . Tabs::widget([
                        'encodeLabels' => false,
                        'items' => $items_frontend]);
                    ?>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="backend">
                    <?=
                    '<h4>Modules :</h4>' . Tabs::widget([
                        'encodeLabels' => false,
                        'items' => $items_backend]);
                    ?>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>        
    </div>
</div>






