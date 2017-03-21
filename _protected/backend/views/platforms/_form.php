<?php

use yii\helpers\Html;
use common\models\Utils;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Platforms */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="platforms-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(Utils::getStatusArr()); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
