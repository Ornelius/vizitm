<?php

use yii\db\Migration;

/**
 * Class m210711_081754_building
 */
class m210711_081754_building extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('{{%building}}',
        [
            'id' => $this->primaryKey(),
            'street_id' => $this->integer()->notNull(),
            'buildingnumber' => $this->string()->notNull(),
            'address' => $this->string()->notNull()->unique(),


        ]);
        $this->createIndex(
            'idx-sreet-street_id',
            '{{%building}}',
            'street_id'
        );
        $this->addForeignKey(
            'fk-sreet-street_id',
            '{{%building}}',
            'street_id',
            '{{%street}}',
            'id'
        );
    }

    public function down()
    {
        $this->dropTable('{{%building}}');
    }
}
