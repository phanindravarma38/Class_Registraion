<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Utils;
use yii\helpers\Url;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $model backend\models\CoursesModel */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courses-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            'code',
            [
            	'label'=>'Platform',
            	'value'=>Utils::getPlatformName($model->platform_id),
            ],
            [
            		'label'=>'Language',
            		'value'=>Utils::getLanguagesName($model->language_id),
            ],
            [
            	'label'=>'Status',
            	'value'=>Utils::getStatusVal($model->status),
            ],
            [
            	'label'=>'Created By',
            	'value'=>Utils::getUserName($model->created_by),
            ],
            'created_date',
            'moodified_date',
        ],
    ]) ?>

</div>
<?php 
    		if(Yii::$app->user->id){
    			$isenrolled = Utils::getEnrolledStatus($model->id,Yii::$app->user->id);
    			if($isenrolled){
    				echo Html::button('Delist', ['value' => Url::to(['site/delistcourse','courseId'=>$model->id,'action'=>'view']), 'title' => 'Delist', 'class' => 'btn btn-sm btn-danger enrollForm']);
    			} else {
    				echo Html::button('Enroll', ['value' => Url::to(['site/enrollcourse','courseId'=>$model->id,'action'=>'view']), 'title' => 'Enroll', 'class' => 'btn btn-sm btn-primary enrollForm']);
    			}
    		}

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