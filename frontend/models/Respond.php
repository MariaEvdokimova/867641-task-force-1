<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "respond".
 *
 * @property int $id
 * @property int $task_id
 * @property int $sender_id
 * @property string|null $description
 * @property int|null $price
 * @property string|null $creation_date
 *
 * @property Users $sender
 * @property Tasks $task
 */
class Respond extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'respond';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'sender_id'], 'required'],
            [['task_id', 'sender_id', 'price'], 'integer'],
            [['description'], 'string'],
            [['creation_date'], 'safe'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['sender_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'sender_id' => 'Sender ID',
            'description' => 'Description',
            'price' => 'Price',
            'creation_date' => 'Creation Date',
        ];
    }

    /**
     * Gets query for [[Sender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(Users::className(), ['id' => 'sender_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }
}
