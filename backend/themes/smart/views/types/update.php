<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = Yii::t('widgets','Update Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('widgets','Widgets Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="types-update">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>