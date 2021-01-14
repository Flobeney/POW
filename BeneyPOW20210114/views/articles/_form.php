<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

//Auteurs
//Fournisseur de données
$dpAuteurs = (new \app\models\AuteursSearch())->search(null);
//Isoler les données voulues
$lstAuteurs = ArrayHelper::map($dpAuteurs->getModels(), 'id', 'prenom');

//Domaines
//Fournisseur de données
$dpDomaines = (new \app\models\DomainesSearch())->search(null);
//Isoler les données voulues
$lstDomaines = ArrayHelper::map($dpDomaines->getModels(), 'id', 'label');

/* @var $this yii\web\View */
/* @var $model app\models\Articles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="articles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date_publication')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'titre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contenu')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'auteurs_id')->dropDownList($lstAuteurs) ?>

	<?= $form->field($model, 'domaines')->dropDownList(
        $lstDomaines,
        ['multiple' => 'multiple']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Ajouter / Modifier', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
