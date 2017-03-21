<?php
namespace common\models;

use yii\helpers\ArrayHelper;
use common\models\User;
use backend\models\CoursesModel;
use backend\models\CourseUser;
use backend\models\Languages;
use backend\models\Platforms;
use common\models\Students;
use yii\helpers\Console;

class Utils{
	
	public static function getAllUsers($status=NULL){
		$array = User::find()->all();
		$list = ArrayHelper::map($array, 'id', 'username');
		return $list;
	}
	
	public static function getUserName($id){
		$arr = self::getAllUsers();
		return $arr[$id];
	}
	
	public static function getAllStudents($status=NULL){
		$array = Students::find()->all();
		$list = ArrayHelper::map($array, 'id', 'username');
		return $list;
	}
	
	public static function getStudentName($id){
		$arr = self::getAllStudents();
		return $arr[$id];
	}
	
	public static function getStatusArr(){
		return array(1=>'Active',0=>'Inactive');
	}
	
	public static function getStatusVal($id){
		$statusArr = self::getStatusArr();
		return $statusArr[$id];
	}
	
	public static function getCoursesList($status=""){
		if($status==1){
			$coursesArr = CoursesModel::findAll(['status'=>1]);
		} else {
			$coursesArr = CoursesModel::find()->all();
		}
		$list = ArrayHelper::map($coursesArr, 'id', 'name');
		return $list;
	}
	
	public static function getCourseName($id){
		$arr = self::getCoursesList();
		return $arr[$id];
	}
	
	public static function getPlatformList($status=""){
		if($status==1){
			$platformsArr = Platforms::findAll(['status'=>1]);
		} else {
			$platformsArr = Platforms::find()->all();
		}
		$list = ArrayHelper::map($platformsArr, 'id', 'name');
		return $list;
	}
	
	public static function getPlatformName($id){
		$arr = self::getPlatformList();
		return $arr[$id];
	}
	
	public static function getLanguagesList($status=""){
		if($status==1){
			$arr = Languages::findAll(['status'=>1]);
		} else {
			$arr = Languages::find()->all();
		}
		$list = ArrayHelper::map($arr, 'id', 'language');
		return $list;
	}
	
	public static function getLanguagesName($id){
		$arr = self::getLanguagesList();
		return $arr[$id];
	}
	
	public static function getEnrolledStatus($cId,$uId){
		if($uId){
			$sql = "SELECT id FROM course_user WHERE course_id=$cId AND user_id=$uId";
			$enroll = CourseUser::findBySql($sql)->one();
			if($enroll){
				return true;
			} else {
				return false;
			}	
		} else {
			return false;
		}	
	}
	
	public static function getStuBatEnrollStatus1($bId,$sId){
		$inst_id = \Yii::$app->user->identity->institute_id;
		if($inst_id){
			$sql = "SELECT id FROM ".$inst_id."_student_batch WHERE inst_id=$inst_id AND student_id=$sId AND batch_id=$bId";
			$enroll = StudentBatch::findBySql($sql)->one();
			if($enroll){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public static function getCurrentDateTime(){
		$created_date = new \DateTime('now');
		return $created_date->format('Y-m-d H:i:s');
	}
}