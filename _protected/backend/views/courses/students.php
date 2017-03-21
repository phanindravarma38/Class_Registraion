<?php
use common\helpers\CssHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Students');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1>

    <?= Html::encode($this->title) ?>

    </h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'username',
            'email:email',
            'mobile',
            [
                'attribute'=>'status',
                'filter' => $searchModel->statusList,
                'value' => function ($data) {
                    return $data->statusName;
                },
                'contentOptions'=>function($model, $key, $index, $column) {
                    return ['class'=>CssHelper::statusCss($model->statusName)];
                }
            ],
        ], // columns
    ]); ?>

</div>
