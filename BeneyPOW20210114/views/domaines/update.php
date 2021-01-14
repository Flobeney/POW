<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Domaines */

$this->title = 'Modifier le domaine : ' . $model->label;
$this->params['breadcrumbs'][] = ['label' => 'Domaines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->label, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="domaines-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
