<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

//Offices
//Fournisseur de données
$dpOffice = (new \app\models\OfficesSearch())->search(null);
//Isoler les données voulues
$lstOffices = ArrayHelper::map($dpOffice->getModels(), 'id', 'label');

//Competences
//Fournisseur de données
$dpComp = (new \app\models\CompetencesSearch())->search(null);
//Isoler les données voulues
$lstComp = ArrayHelper::map($dpComp->getModels(), 'id', 'domaine');

/* @var $this yii\web\View */
/* @var $model app\models\Persons */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="persons-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'age')->textInput() ?>

    <?= $form->field($model, 'offices_id')->dropDownList($lstOffices) ?>

    <?= $form->field($model, 'competences')->widget(
        Select2::classname(), 
        [
            'data' => $lstComp,
            'options' => [
                'placeholder' => 'Select competences',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
