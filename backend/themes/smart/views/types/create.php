<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = 'Create Types';
$this->params['breadcrumbs'][] = ['label' => 'Widgets Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="types-create">

 
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>