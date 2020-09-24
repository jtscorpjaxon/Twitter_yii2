<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 */
class m200922_004933_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'text'=>$this->text(),
            'user_id'=>$this->bigInteger()->unsigned()->notNull(),
            'post_id'=>$this->bigInteger()->unsigned()->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' =>$this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comments}}');
    }
}
