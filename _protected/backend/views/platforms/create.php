<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Platforms */

$this->title = 'Create Platform';
$this->params['breadcrumbs'][] = ['label' => 'Platforms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="platforms-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
