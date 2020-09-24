<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "likes".
 *
 * @property int $id
 * @property int|null $is_like
 * @property int|null $is_dislike
 * @property int $user_id
 * @property int $post_id
 */
class Likes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'likes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_like', 'is_dislike', 'user_id', 'post_id'], 'integer'],
            [['user_id', 'post_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_like' => 'Is Like',
            'is_dislike' => 'Is Dislike',
            'user_id' => 'User ID',
            'post_id' => 'Post ID',
        ];
    }
}
