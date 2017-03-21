<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CoursesModel */

$this->title = 'Create Course';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courses-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
