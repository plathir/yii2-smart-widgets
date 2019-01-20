<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Tabs;
use plathir\widgets\common\helpers\WidgetHelper;
use yii\helpers\Url;
?>
<?php
$widgetHelper = new WidgetHelper();
$ListModules = $widgetHelper->getListOfModules();
$items_frontend = [];
$items_backend = [];

foreach ($ListModules as $ModuleName) {
    $h_params[$ModuleName["env"]][$ModuleName["module_name"]]["Widgets_s"] = [
        'id' => '',
        'name' => '',
        'environment' => '',
        'module_name' => $ModuleName["module_name"],
   //     'module_name' => $ModuleName["module_name"],
        'publish' => ''
    ];
    echo '<pre>';
  //  echo $ModuleName["module_name"];
    print_r($ListModules);
    echo '</pre>';
    
    $grid = GridView::widget([
                'dataProvider' => $searchModel->search($h_params[$ModuleName["env"]][$ModuleName["module_name"]]),
                'showOnEmpty' => false,
                'emptyText' => 'NoData',
                'columns' => [
                    [
                        'attribute' => 'id',
                    ],
                    [
                        'attribute' => 'name',
                    ],
                    [
                        'attribute' => 'module_name',
                    ],

                    //   'name',
                    [
                        'attribute' => 'publish',
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
                                $url = Url::to(['widgets/view', 'id' => $model->id]);
                                return $url;
                            }
                            if ($action === 'update') {
                                $url = Url::to(['widgets/update', 'id' => $model->id]);
                                return $url;
                            }
                            if ($action === 'delete') {
                                $url = Url::to(['widgets/delete', 'id' => $model->id]);
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
?>


<?php
//
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


<br>
<br>
<br>
<br>








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
                    //  'filter' => \yii\bootstrap\Html::activeDropDownList($searchModel, 'position', \yii\helpers\ArrayHelper::map(plathir\widgets\backend\models\Positions::find()->all(), 'id', 'name'), ['class' => 'form-control', 'prompt' => Yii::t('widgets', 'Select...')]),
                    ],
                    [
                        'attribute' => 'publish',
                        'value' => function($model, $key, $index, $widget) {
                            return $model->publishbadge;
                        },
                        'format' => 'html',
                        //  'filter' => \yii\bootstrap\Html::activeDropDownList($searchModel, 'publish', ['0' => Yii::t('widgets', 'Unpublished'), '1' => Yii::t('widgets', 'Published')], ['class' => 'form-control', 'prompt' => Yii::t('widgets', 'Select...')]),
                        'contentOptions' => ['style' => 'width: 10%;']
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:' . Yii::$app->settings->getSettings('ShortDateFormat')],
                        'value' => 'created_at',
                        //'filter' => \backend\widgets\SmartDate::widget(['type' => 'filterShortDate', 'model' => $searchModel, 'attribute' => 'created_at']),
                        'contentOptions' => ['style' => 'width: 12%;']
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => ['date', 'php:' . Yii::$app->settings->getSettings('ShortDateFormat')],
                        'value' => 'updated_at',
                        // 'filter' => \backend\widgets\SmartDate::widget(['type' => 'filterShortDate', 'model' => $searchModel, 'attribute' => 'updated_at']),
                        'contentOptions' => ['style' => 'width: 12%;']
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'min-width: 70px;',
                            'class' => 'btn-loader',
                        ]
                    ]
                ]
            ]);
            ?>

        </div>
    </div>



</div>  