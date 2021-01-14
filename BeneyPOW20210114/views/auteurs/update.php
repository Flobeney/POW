<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Auteurs */

$this->title = 'Modifier l\'auteur : ' . $model->nom . ' ' . $model->prenom;
$this->params['breadcrumbs'][] = ['label' => 'Auteurs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nom . ' ' . $model->prenom, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modifier';
?>
<div class="auteurs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
