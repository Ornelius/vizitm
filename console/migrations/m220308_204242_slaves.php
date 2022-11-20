<?php

use yii\db\Migration;

/**
 * Class m220308_204242_slaves
 */
class m220308_204242_slaves extends Migration
{
    /**
     * {@inheritdoc}
     */


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('slave',
            [
                'id'                    => $this->primaryKey()->notNull(),
                'master_id'             => $this->integer()->notNull(),
                'slave_id'              => $this->integer()->notNull(),
            ]
        );

        $this->createIndex(
            'idx-slave-master_id',
            'slave',
            'master_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-slave-master_id',
            'slave',
            'master_id',
            'users',
            'id',
            'CASCADE'
        );
        return true;

    }

    public function down()
    {

        $this->dropForeignKey(
            'fk-slave-master_id',
            'slave'
        );

        $this->dropIndex(
            'idx-slave-master_id',
            'slave'
        );


        $this->dropTable('slave');

        echo "m220308_204242_slaves cannot be reverted.\n";

        return true;
    }

}
