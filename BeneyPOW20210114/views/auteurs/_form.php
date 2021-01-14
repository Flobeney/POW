<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

//Types
//Fournisseur de données
$dpTypes = (new \app\models\TypesSearch())->search(null);
//Isoler les données voulues
$lstTypes = ArrayHelper::map($dpTypes->getModels(), 'id', 'type');

/* @var $this yii\web\View */
/* @var $model app\models\Auteurs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auteurs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prenom')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'types_id')->dropDownList($lstTypes) ?>

    <div class="form-group">
        <?= Html::submitButton('Ajouter / Modifier', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
