<?php

use yii\db\Migration;

/**
 * Class m210623_191407_city
 */
class m210623_191407_city extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%cities}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'extra' => $this->string(),
        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cities}}');

        //echo "m210623_191407_city cannot be reverted.\n";

        //return false;
    }
}
