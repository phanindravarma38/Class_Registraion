<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use common\models\Utils;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
//$this->title = Yii::t('app', Yii::$app->name);
$this->title = 'Search Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courses-model-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['method' => 'get']); ?>
    <div class="row">
    	<div class="col-lg-4">
    		<?= $form->field($searchModel, 'name')->textInput(['maxlength' => true]) ?>
    	</div>
    	<div class="col-lg-4">
    		<?= $form->field($searchModel, 'platform_id')->dropDownList(Utils::getPlatformList(1),['prompt'=>'Select Platform']); ?>
    	</div>
    	<div class="col-lg-4">
    		<?= $form->field($searchModel, 'language_id')->dropDownList(Utils::getLanguagesList(1),['prompt'=>'Select Language']); ?>
    	</div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Apply', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?=
	   ListView::widget([
	    		'dataProvider' => $dataProvider,
	    		'itemView' => '_course',
	    ]);
    ?>
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
<style>
.course{
	padding:10px;
	margin-bottom:15px;
	border: 1px solid #efefef;
	border-radius:5px;
}
.course h4{margin:0 0 10px 15px;font-size:18px;font-weight:bold;}
</style>