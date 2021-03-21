<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = $model->tech_name . '-' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('widgets', 'Positions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('widgets', 'View Position : {title}', ['title' => Html::encode($this->title)]) ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>

    </div><!-- /.box-header -->
    <div class="box-body">
        <p>
            <?= Html::a(Yii::t('widgets', 'Update'), ['update', 'tech_name' => $model->tech_name], ['class' => 'btn btn-primary btn-flat']) ?>

            <?=
            Html::a(Yii::t('widgets', 'Delete'), ['delete', 'tech_name' => $model->tech_name], [
                'class' => 'btn btn-danger btn-flat',
                'data' => [
                    'confirm' => Yii::t('widgets', 'Are you sure you want to delete this item ?'),
                    'method' => 'post',
                ],
            ]);
            ?>
            <?= Html::a(Yii::t('widgets', 'Sort Order'), ['/widgets/positions_sorder/update', 'tech_name' => $model->tech_name], ['class' => 'btn btn-primary btn-flat']) ?>
        </p>

        <?=
        DetailView::widget([
            'model' => $model,
            'template' => '<tr><th style="width:20%">{label}</th><td style="width:80%">{value}</td></tr>',
            'attributes' => [
                'tech_name',
                'name',
                'environment',
                'publishbadge:html'
            ]
        ]);


        $provider = new ArrayDataProvider([
            'allModels' => $model->widgets,
            'sort' => [
                'attributes' => ['id', 'name', 'positiondescr', 'publishbadge'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        ?>
        <br>
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('widgets', 'Widgets with position : {name} ', ['name' => $model->name]) ?></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php
                echo GridView::widget([
                    'dataProvider' => $provider,
                    'tableOptions' => ['class' => 'table table-responsive table no-margin'],
                    'columns' => [
                        'id',
                        [
                            'attribute' => 'name',
                            'value' => function($model) {
                                return Html::a($model->name, ['/widgets/default/view', 'id' => $model->id]);
                            },
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'widgettypedescr',
                            'value' => function($model) {
                                return Html::a($model->widgettypedescr, ['/widgets/types/view', 'tech_name' => $model->widget_type]);
                            },
                            'format' => 'html',
                        ],
                        'publishbadge:html',
                ]]);
                ?>


            </div>
        </div>            
    </div>
</div>
