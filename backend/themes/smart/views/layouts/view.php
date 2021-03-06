<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = $model->tech_name . '-' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('widgets', 'Layouts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('widgets', 'View Layout : {title}', ['title' => Html::encode($this->title)]) ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>

    </div><!-- /.box-header -->
    <div class="box-body">
        <p>
            <?= Html::a('<i class="fa fa-fw fa-edit"></i> '.Yii::t('widgets', 'Update'), ['update', 'tech_name' => $model->tech_name], ['class' => 'btn btn-primary btn-flat']) ?>

            <?=
            Html::a('<i class="fa fa-fw fa-trash"></i> '.Yii::t('widgets', 'Delete'), ['delete', 'tech_name' => $model->tech_name], [
                'class' => 'btn btn-danger btn-flat',
                'data' => [
                    'confirm' => Yii::t('widgets', 'Are you sure you want to delete this item ?'),
                    'method' => 'post',
                ],
            ]);
            ?>
        </p>

        <?=
        DetailView::widget([
            'model' => $model,
            'template' => '<tr><th style="width:20%">{label}</th><td style="width:80%">{value}</td></tr>',
            'attributes' => [
                'tech_name',
                'name',
                'path',
                'fullpath',
                'themepath',
           //     'activethemepath',
                'module_name',
                ['attribute' => 'positions',
                    'value' => function( $model ) {
                        return implode(",", $model->positions);
                    }
                ],
                'html_layout:html',
                'environment',
                'publishbadge:html'
            ]
        ]);
        ?>
    </div>
</div>
