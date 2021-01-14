<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DomainesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Domaines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="domaines-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ajouter un domaine', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'label',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
