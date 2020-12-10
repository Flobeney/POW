<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Competences */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="competences-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'domaine')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
