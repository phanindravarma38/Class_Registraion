<?php

use yii\helpers\Html;
use common\models\Utils;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Languages */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Languages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="languages-view">

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
            //'id',
            'language',
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
