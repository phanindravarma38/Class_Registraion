<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Utils;
use yii\helpers\Url;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CoursesSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
$userId = false;
if(Yii::$app->user->id){
	$userId = Yii::$app->user->id; 
}
?>
<div class="courses-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
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
	        [
		       'label'=>'Action',
		       'format' => 'raw',
		       'value'=>function ($data) use ($userId) {
		       		if($userId){
		       			return Html::button('Enroll', ['value' => Url::to(['site/enrollcourse','courseId'=>$data->id,'userId'=>$userId]), 'title' => 'Enroll', 'class' => 'enrollForm btn btn-sm btn-primary']);
		       		} else {
		       			return false;
		       		}			            
		        },
		    ]
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
<?php
yii\bootstrap\Modal::begin([
	'header' => '<span id="modalHeaderTitle"></span>',
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'enrollModal',
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'><div style='text-align:center'>".Html::img(Yii::$app->view->theme->baseUrl.'/images/loading.gif',['alt'=>'loading'])."</div></div>";
yii\bootstrap\Modal::end();

$js = "
	$(document).on('click', '.enrollForm', function(){
		var title = '<h4>' + $(this).attr('title') + '</h4>';
		if ($('#enrollModal').data('bs.modal').isShown) {
            $('#enrollModal').find('#modalContent').load($(this).attr('value'));
            //dynamiclly set the header for the modal via title tag
            $('#enrollModal #modalHeaderTitle').html(title);
        } else {
            //if modal isn't open; open it and load content
            $('#enrollModal').modal('show').find('#modalContent').load($(this).attr('value'));
             //dynamiclly set the header for the modal via title tag
            $('#enrollModal #modalHeaderTitle').html(title);
        }
    });
	$('#enrollModal').on('hidden.bs.modal', function () {
		$('#enrollModal').find('#modalContent').html('<div style=\'text-align:center\'>".Html::img('@web/images/loading.gif',['alt'=>'loading'])."</div>');
	});
";
$this->registerJs($js, \yii\web\View::POS_READY);
?>