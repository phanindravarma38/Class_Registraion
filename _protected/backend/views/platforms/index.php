<?php

use yii\helpers\Html;
use common\models\Utils;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlatformsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Platforms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="platforms-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Platform', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'url:url',
            [
	            'attribute'=>'status',
	            'content'=>function($data){
	            	return Utils::getStatusVal($data->status);
	            },
	            'filter'=>Utils::getStatusArr(),
	        ],
            [
	            'attribute'=>'created_by',
	            'content'=>function($data){
	            	return Utils::getUserName($data->created_by);
	            },
	            'filter'=>Utils::getAllUsers(),
	        ],
            // 'created_date',
            // 'modified_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
