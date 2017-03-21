<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "languages".
 *
 * @property integer $id
 * @property string $language
 * @property integer $status
 * @property integer $created_by
 * @property string $created_date
 * @property string $modified_date
 */
class Languages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'languages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language', 'created_by', 'created_date'], 'required'],
            [['status', 'created_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['language'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'language' => 'Language',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
        ];
    }
}
