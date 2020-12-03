<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Offices */

$this->title = 'Create Offices';
$this->params['breadcrumbs'][] = ['label' => 'Offices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offices-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
