<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = 'Update Position Sort Order';
$this->params['breadcrumbs'][] = ['label' => 'Positions Sort Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="types-update">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>