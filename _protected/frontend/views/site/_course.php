<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use common\models\Utils;
?>
<div class="course">
    <h4><?= Html::a(Html::encode($model->name),['view','id'=>$model->id]); ?></h4>

    <div class="row">
    	<div class="col-xs-12 col-sm-12 col-md-8">
    		<div class="col-xs-12 col-sm-12 col-md-6">
    			Code : <?= HtmlPurifier::process($model->code) ?>
	    	</div>
	    	<div class="col-xs-12 col-sm-12 col-md-6">
	    		Platform : <?= HtmlPurifier::process(Utils::getPlatformName($model->platform_id)) ?>
	    	</div>
	    	<div class="col-xs-12 col-sm-12 col-md-6">
	    		Language : <?= HtmlPurifier::process(Utils::getLanguagesName($model->language_id)) ?>
	    	</div>
	    </div>
	    <div class="col-xs-12 col-sm-12 col-md-4 text-center">
	    	<?php 
	    		if(Yii::$app->user->id){
	    			$isenrolled = Utils::getEnrolledStatus($model->id,Yii::$app->user->id);
	    			if($isenrolled){
	    				echo Html::button('Delist', ['value' => Url::to(['site/delistcourse','courseId'=>$model->id,'action'=>'index']), 'title' => 'Delist', 'class' => 'btn btn-sm btn-danger enrollForm']);
	    			} else {
	    				echo Html::button('Enroll', ['value' => Url::to(['site/enrollcourse','courseId'=>$model->id,'action'=>'index']), 'title' => 'Enroll', 'class' => 'btn btn-sm btn-primary enrollForm']);
	    			}
	    		}
	    	?>
	    </div>
    </div>    
</div>