<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Utils;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LanguagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Languages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="languages-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Language', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'language',
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
            // 'modified_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
