<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Auteurs */

$this->title = 'Ajouter un auteur';
$this->params['breadcrumbs'][] = ['label' => 'Auteurs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auteurs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
