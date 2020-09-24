<?php

use yii\db\Migration;

/**
 * Class m200923_055154_subcsribe
 */
class m200923_055154_subcsribe extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subcsribe}}', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->bigInteger()->unsigned()->notNull(),
            'subscribe'=>$this->json(),


        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200923_055154_subcsribe cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200923_055154_subcsribe cannot be reverted.\n";

        return false;
    }
    */
}
