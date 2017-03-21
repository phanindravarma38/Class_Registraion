<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Utils;

/* @var $this yii\web\View */
/* @var $model backend\models\Platforms */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Platforms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="platforms-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url:url',
            [
            	'label'=>'Status',
            	'value'=>Utils::getStatusVal($model->status),
            ],
            [
            	'label'=>'Created By',
            	'value'=>Utils::getUserName($model->created_by),
            ],
            'created_date',
            'modified_date',
        ],
    ]) ?>

</div>
