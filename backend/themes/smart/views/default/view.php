<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = $model->id . '-' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('widgets', 'Widgets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('widgets', 'View Widget : {title} ', ['title' => Html::encode($this->title)]) ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>

    </div><!-- /.box-header -->
    <div class="box-body">
        <p>
            <?= Html::a('<i class="fa fa-fw fa-plus"></i> '.Yii::t('widgets', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('<i class="fa fa-fw fa-trash"></i> '.Yii::t('widgets', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('widgets', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
            ?>
            <?= Html::a('<i class="glyphicon glyphicon-search"></i> '.Yii::t('widgets', 'Preview'), ['preview', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>

        <?=
        DetailView::widget([
            'model' => $model,
            'template' => '<tr><th style="width:20%">{label}</th><td style="width:80%">{value}</td></tr>',
            'attributes' => [
                'id',
                'widgettypedescr',
                'name',
                'description',
                'positiondescr',
                'config',
                'rules',
                'publishbadge:html',
                'created_at:datetime',
                'updated_at:datetime',
            ]
        ]);
        ?>
    </div>
</div>
