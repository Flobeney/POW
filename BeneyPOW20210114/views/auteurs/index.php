<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AuteursSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auteurs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auteurs-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Auteurs', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nom',
            'prenom',
            'types_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
