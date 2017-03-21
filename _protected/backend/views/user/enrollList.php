<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Utils;
use yii\helpers\Url;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $model backend\models\CoursesModel */

$this->title = 'Enroll Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="enrollDetails">
	<table class="table table-bordered">
		<thead>
			<th>Sr.No</th>
			<th>Course</th>
			<th>Student</th>
			<th>Enrolled on </th>
		</thead>
		<tbody>
			<?php $i=1; foreach ($models as $model){ ?>
				<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo Utils::getCourseName($model->course_id); ?></td>
				<td><?php echo Utils::getStudentName($model->user_id); ?></td>
				<td><?php echo $model->created_date; ?></td>
				</tr>
			<?php $i++; } ?>
		</tbody>
	</table>
</div>
