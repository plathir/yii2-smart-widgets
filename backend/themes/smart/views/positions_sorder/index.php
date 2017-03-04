<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\ArrayHelper;
?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('widgets','List of Widgets Types') ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= Html::a(Yii::t('widgets','Create new Position'), ['create'], ['class' => 'btn btn-success']) ?>


        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'position_id',
                ],
                [
                    'attribute' => 'widget_sort_order',
                ],

                        ['class' => 'yii\grid\ActionColumn']
                    ]
                ]);
                ?>


    </div>
</div>






