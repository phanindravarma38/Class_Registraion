<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Utils;

/* @var $this yii\web\View */
/* @var $model backend\models\CoursesModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="courses-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'platform_id')->dropDownList(Utils::getPlatformList(1),['prompt'=>'Select Platform']); ?>
    
    <?= $form->field($model, 'language_id')->dropDownList(Utils::getLanguagesList(1),['prompt'=>'Select Language']); ?>
    
    <?= $form->field($model, 'status')->dropDownList(Utils::getStatusArr()); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
