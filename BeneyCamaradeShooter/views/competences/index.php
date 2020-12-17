<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CompetencesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Competences';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="competences-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Competences', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'domaine',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <!-- Utilisation du widget -->
    <?= app\widgets\Nuage::widget() ?>

</div>
