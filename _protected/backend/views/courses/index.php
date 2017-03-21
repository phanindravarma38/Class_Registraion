<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Utils;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CoursesSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courses-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Course', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'code',
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
            'created_date',
            // 'moodified_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
