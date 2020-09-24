<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property string $title
 * @property string $image
 * @property string $text
 * @property int $user_id
 * @property string $created_at
 * @property string|null $updated_at
 */
class Posts extends \yii\db\ActiveRecord
{
    public $img;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }
    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>['created_at','updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE=>['updated_at'],

                ],
                'value'=>new Expression('NOW()')
            ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title','text'], 'required'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['img'], 'file',  'extensions' => 'png, jpg'],
            [['title', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'img' => 'Image',
            'text' => 'Comment Text',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function upload($dir){
        if($this->validate()){
             $file=$this->img;
                $path = "images/$dir/$this->id/" ;
                FileHelper::createDirectory($path);
                $path .= $file->baseName . '.' . $file->extension;

                $file->saveAs($path);
            return true;
        }else{
            return false;
        }
    }
}
