<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Competences */

$this->title = 'Create Competences';
$this->params['breadcrumbs'][] = ['label' => 'Competences', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="competences-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
