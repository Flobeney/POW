<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

//Articles
//Fournisseur de données
$params['ArticlesSearch']['auteurs_id'] = $model->id;
$dpArticles = (new \app\models\ArticlesSearch())->search($params);
$dpArticles->pagination = false;
$lstArticles = $dpArticles->getModels();

/* @var $this yii\web\View */
/* @var $model app\models\Auteurs */

$this->title = $model->nom . ' ' . $model->prenom;
$this->params['breadcrumbs'][] = ['label' => 'Auteurs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="auteurs-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modifier', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Supprimer', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nom',
            'prenom',
            'types.type',
        ],
    ]) ?>

	<!-- Utilisation du widget -->
	<?php
		foreach ($lstArticles as $article) {
			echo app\widgets\DisplayArticle::widget(['article' => $article]);
		}
	?>

</div>
