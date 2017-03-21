<?php

use yii\helpers\Html;
use common\models\Utils;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Languages */
$this->title = $model->name;
$this->params['breadcrumbs'][] = 'Profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="languages-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            'username',
            'email:email',
            'mobile',
            [
            	'label'=>'Created Date',
            	'value'=>Yii::$app->formatter->asDate($model->created_at, 'dd-MM-yyyy')
            ],
            [
            	'label'=>'Modified Date',
            	'value'=>Yii::$app->formatter->asDate($model->updated_at, 'dd-MM-yyyy')
            ],
        ],
    ]) ?>

</div>
