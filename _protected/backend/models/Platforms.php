<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "platforms".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property integer $status
 * @property integer $created_by
 * @property string $created_date
 * @property string $modified_date
 */
class Platforms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'platforms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'created_by', 'created_date'], 'required'],
            [['status', 'created_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 255],
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
            'url' => 'Url',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
        ];
    }
}
