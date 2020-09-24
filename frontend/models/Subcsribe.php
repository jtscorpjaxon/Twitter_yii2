<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subcsribe".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $subscribe
 */
class Subcsribe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subcsribe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['subscribe'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'subscribe' => 'Subscribe',
        ];
    }
}
