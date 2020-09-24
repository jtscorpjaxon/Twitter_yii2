<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts}}`.
 */
class m200922_004906_create_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts}}', [
            'id' => $this->primaryKey(),
            'title'=>$this->string()->notNull(),
            'image'=>$this->string()->notNull(),
            'text'=>$this->text(),
            'user_id'=>$this->bigInteger()->unsigned()->notNull(),
            'created_at' =>$this->datetime()->notNull(),
            'updated_at' => $this->datetime(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%posts}}');
    }
}
