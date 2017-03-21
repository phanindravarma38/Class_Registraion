<?php

namespace backend\models;

use Yii;
use common\models\Students;
use backend\models\CoursesModel;

/**
 * This is the model class for table "course_user".
 *
 * @property integer $id
 * @property integer $course_id
 * @property integer $user_id
 * @property string $created_date
 * @property string $modified_date
 *
 * @property User $user
 * @property Courses $course
 */
class CourseUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'user_id', 'created_date'], 'required'],
            [['course_id', 'user_id'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Students::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => CoursesModel::className(), 'targetAttribute' => ['course_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_id' => 'Course ID',
            'user_id' => 'User ID',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Courses::className(), ['id' => 'course_id']);
    }
}
