<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "courses".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $status
 * @property integer $created_by
 * @property string $created_date
 * @property string $moodified_date
 */
class CoursesModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'courses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_by', 'created_date','platform_id','language_id'], 'required'],
            [['status', 'created_by','platform_id','language_id'], 'integer'],
            [['created_date', 'moodified_date'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['code'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'status' => 'Status',
        	'platform_id' => 'Platform',
        	'language_id' => 'Language',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'moodified_date' => 'Moodified Date',
        ];
    }
}
