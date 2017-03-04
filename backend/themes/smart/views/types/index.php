<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\ArrayHelper;
?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">List of Widgets Types</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= Html::a('Create new Type', ['create'], ['class' => 'btn btn-success']) ?>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [

                [
                    'attribute' => 'id',
                ],
                [
                    'attribute' => 'tech_name',
                ],
                
                [
                    'attribute' => 'environment',
                    'format' => 'html',
                    'filter' => Html::activeDropDownList($searchModel, 'environment', ['backend' => 'backend', 'frontend' => 'frontend'], ['class' => 'form-control', 'prompt' => 'Select...'])
                ],
                [
                    'attribute' => 'module_name',
                    'format' => 'html',
                    'filter' => Html::activeDropDownList($searchModel, 'module_name', ArrayHelper::map($searchModel->moduleslist, 'module_name', 'module_name'), ['class' => 'form-control', 'prompt' => 'Select...'])
                ],
                [
                    'attribute' => 'widget_name',
                ],
                [
                    'attribute' => 'widget_class',
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'min-width: 70px;']
                ]
            ]
        ]);
        ?>


    </div>
</div>






