<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\models\Utils;
?>
<div class="add-form">
	<?php //echo '<pre>';print_r($studentBatch);echo '</pre>';exit; 
		$form = ActiveForm::begin([
							'id' => 'user-enroll-form',
							'enableAjaxValidation' => false,
							'enableClientValidation' => true,
							'validateOnSubmit'=>true]);
	?>
	<div class="form-div-main border-none">
		<div class="form-fields-div" style="padding: 1% 0;">
			<div class="row enrollexist" style="margin: 0 0 10px 0;display:none;color:#a94442;"></div>
			<?php 
				$template = '<div class="row"><div class="col-xs-5">{label}{hint}</div> <div class="col-xs-7">{input}{error}</div></div>'; 
			?>
		    <div class="row" style="margin: 0;">
		    	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		    		Course Name : <?php echo $courses[$enrollForm->course_id]; ?>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                	User : <?php echo $userName; ?>
                </div>
			</div>
		</div>
		<div class="buttons-div buttons-div-bottom border-none">
			<?= Html::submitButton('Submit', ['class'=> 'btn btn-sm btn-success','id'=>'accept-button-enroll']) ;?>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
</div>