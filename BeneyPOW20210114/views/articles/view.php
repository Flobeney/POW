<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = $model->titre;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="articles-view">

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
            'date_publication',
            'titre',
			'contenu:ntext',
			[
                'attribute' => 'auteurs_id',
                'label' => 'Auteur',
                'value' => function($model){
					$type = $model->auteurs->types != null ? ' (' . $model->auteurs->types->type . ')' : '';
                    return $model->auteurs->nom . ' ' . $model->auteurs->prenom . $type;
                }
            ],
			[
                'attribute' => 'domaines',
				'label' => 'Domaines',
				'format' => 'html',
                'value' => function($model){
					$res = '';
					foreach ($model->domaines as $domaine) {
						$res .= $domaine->label . ', ';
					}
					//Enlever la dernière virgule
					$res = substr($res, 0, -2);

                    return $res;
                }
            ],
        ],
    ]) ?>

</div>
