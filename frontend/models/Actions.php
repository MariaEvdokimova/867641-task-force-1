<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "actions".
 *
 * @property int $id
 * @property string $action_name
 */
class Actions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['action_name'], 'required'],
            [['action_name'], 'string', 'max' => 128],
            [['action_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'action_name' => 'Action Name',
        ];
    }
}
