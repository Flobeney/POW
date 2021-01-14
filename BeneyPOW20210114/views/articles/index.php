<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticlesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ajouter un article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'date_publication',
            'titre',
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
					$res = '<ul>';
					foreach ($model->domaines as $domaine) {
						$res .= '<li>' . $domaine->label . '</li>';
					}
					$res .= '</ul>';

                    return $res;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
