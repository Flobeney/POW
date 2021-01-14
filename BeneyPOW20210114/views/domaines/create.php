<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Domaines */

$this->title = 'Create Domaines';
$this->params['breadcrumbs'][] = ['label' => 'Domaines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="domaines-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
