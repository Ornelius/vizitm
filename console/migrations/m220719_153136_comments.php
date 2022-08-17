<?php

use yii\db\Migration;

/**
 * Class m220719_153136_comments
 */
class m220719_153136_comments extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up(): bool
    {
        $this->createTable('comments',
            [
                'id'                        => $this->primaryKey()->notNull(),
                'request_id'                => $this->integer()->notNull(),
                'user_id'                   => $this->integer()->notNull(),
                'comment'                   => $this->text(),
                'datetime'                  => $this->integer(),
            ]
        );

        $this->createIndex(
            'idx-comments-request_id',
            'comments',
            'request_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-comments-request_id',
            'comments',
            'request_id',
            'request',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-comments-user_id',
            'comments',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-comments-user_id',
            'comments',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        return true;


    }



    public function down(): bool
    {
        $this->dropForeignKey(
            'fk-comments-user_id',
            'comments'
        );

        $this->dropIndex(
            'idx-comments-user_id',
            'comments'
        );

        $this->dropForeignKey(
            'fk-comments-request_id',
            'comments'
        );

        $this->dropIndex(
            'idx-comments-request_id',
            'comments'
        );

        $this->dropTable('comments');
            echo "m220719_153136_comments cannot be reverted.\n";

            return true;

    }
}
