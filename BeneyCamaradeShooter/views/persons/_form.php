<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

//Fournisseur de données
$dataprovider = (new \app\models\OfficesSearch())->search(null);
//Isoler les données voulues
$lstOffices = \yii\helpers\ArrayHelper::map($dataprovider->getModels(), 'id', 'label');

/* @var $this yii\web\View */
/* @var $model app\models\Persons */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="persons-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'age')->textInput() ?>

    <?= $form->field($model, 'offices_id')->dropDownList($lstOffices) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
