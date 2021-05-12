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
?>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('widgets', 'List of Widngets') ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= Html::a('<i class="fa fa-fw fa-plus"></i> '.Yii::t('widgets', 'Create new Widget'), ['create'], ['class' => 'btn btn-success btn-flat btn-loader']) ?>
        <br>
        <br>
        <blockquote>
            <p><?= \Yii::t('widgets', 'The Widgets caregorized to Frontend and Backend environment ( and Module tabs ) by Module Name that exist within Position') ?></p>
            <footer><?= \Yii::t('widgets', 'The Position may belong to a different Module Name than the module name that exists within the Widget type') ?></footer>
        </blockquote>


        <?php
        foreach ($ListModules as $ModuleName) {
            $h_params[$ModuleName["env"]][$ModuleName["module_name"]]["Widgets_s"] = [
                'id' => '',
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
                            'id',
                            [
                                'attribute' => 'name',
                                'value' => function($model) {
                                    return '<strong>' . $model->name .
                                            '</strong>' . '<br><i><u>'. \Yii::t('widgets','Type').'</u> : ' .
                                            '<span class="text-green">' . $model->widgetref->tech_name . '</span> - ' .
                                            $model->widgetref->widget_name .
//                                            '<br><u>class</u> :'. $model->widgetref->widget_class. '</i>';
                                            '<br><u>'.Yii::t('widgets','Class').'</u> : <span class="text-red">' . $model->widgetref->widget_class . '</span></i>';
                                },
                                'format' => 'raw',
                            ],
                            'positionref.name',
//                            'positionref.module_name',
//                            'environment',                                        
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
                                'attribute' => 'publish',
                                'value' => function($model, $key, $index, $widget) {
                                    return $model->publishbadge;
                                },
                                'format' => 'html',
                                //  'filter' => \yii\bootstrap\Html::activeDropDownList($searchModel, 'publish', ['0' => Yii::t('widgets', 'Unpublished'), '1' => Yii::t('widgets', 'Published')], ['class' => 'form-control', 'prompt' => Yii::t('widgets', 'Select...')]),
                                'contentOptions' => ['style' => 'width: 10%;']
                            ],
//                    ['attribute' => 'module_name',
//                        'value' => 'widgetref.module_name'
//                    ],
                            ['class' => 'yii\grid\ActionColumn',
                                'contentOptions' => ['style' => 'min-width: 70px;',
                                    'class' => 'btn-loader',
                                ]
                            ],
                        ],
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

<?php
//$grid = GridView::widget([
//            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
//            'showOnEmpty' => false,
//            'emptyText' => 'NoData',
//            'columns' => [
//                'id',
//                'name',
//                'environment',
//                [
//                    'attribute' => 'module_name',
//                    'value' => 'widgetref.module_name'
//                ],
//            ],
//        ]);
//
//
//echo $grid;
?>