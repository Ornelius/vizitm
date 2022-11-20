<?php

use yii\db\Migration;

/**
 * Class m210711_122218_request
 */
class m210711_122218_request extends Migration
{


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('{{%request}}',
            [
                'id'                => $this->primaryKey(),
                'building_id'       => $this->integer()->notNull(),
                'user_id'           => $this->integer()->notNull(),
                'description'       => $this->text()->notNull(),
                'created_at'        => $this->integer()->notNull(),
                'type'              => $this->integer()->notNull(),
                'room'              => $this->integer()->notNull(),
                'deleted'           => $this->boolean(),
                'deleted_at'        => $this->integer(),
                'done'              => $this->boolean(),
                'done_at'           => $this->integer(),
                'invoice'           => $this->boolean(),
                'invoce_at'         => $this->integer(),
                'type_of_work'      => $this->integer(),
                'status'            => $this->integer(),
                'description_done'  => $this->string(),
                'public'            => $this->integer(),
                'importance'        => $this->integer(),
                'main_photo'        => $this->string(),
                'due_date'          => $this->integer()->null(),
                'work_whom'         => $this->integer()->null(),
                'cost'              => $this->double()->null(),
            ]);

        $this->createIndex(
            'idx-request-building_id',
            '{{%request}}',
            'building_id'
        );
        $this->addForeignKey(
            'fk-request-building_id',
            '{{%request}}',
            'building_id',
            '{{%building}}',
            'id'
        );
        $this->createIndex(
          'idx-request-user_id',
          '{{%request}}',
          'user_id'
        );
        $this->addForeignKey(
            'fk-request-user_id',
            '{{%request}}',
            'user_id',
            '{{%users}}',
            'id'
        );

        $this->createTable('{{%photo}}',
            [
                'id'                => $this->primaryKey(),
                'request_id'        => $this->integer()->notNull(),
                'path'              => $this->string()->notNull(),
                'sort'              => $this->integer(),
                'type'              => $this->integer(),

            ]);
        $this->createIndex(
            'idx-photo-request_id',
            '{{%photo}}',
            'request_id'
        );
        $this->createTable('{{%video}}',
            [
                'id'                => $this->primaryKey(),
                'request_id'        => $this->integer()->notNull(),
                'path'              => $this->string()->notNull(),
                'sort'              => $this->integer(),
                'type'              => $this->integer(),

            ]);
        $this->createIndex(
            'idx-video-request_id',
            '{{%video}}',
            'request_id'
        );
        $this->addForeignKey(
            'fk-photo-request_id',
            '{{%photo}}',
            'request_id',
            '{{%request}}',
            'id'
        );
        $this->addForeignKey(
            'fk-video-request_id',
            '{{%video}}',
            'request_id',
            '{{%request}}',
            'id'
        );

        $this->createTable('{{%direct}}',
            [
                'id'                    =>  $this->primaryKey(),
                'request_id'            =>  $this->integer()->notNull(),
                'direct_datetime'       =>  $this->integer(),
                'direct_from'           =>  $this->integer(),
                'direct_to'             =>  $this->integer(),

            ]);
        $this->createIndex(
          'idx-direct-request_id',
          '{{%direct}}',
          'request_id'
        );
        $this->addForeignKey(
            'fk-direct-request_id',
            '{{%direct}}',
            'request_id',
            '{{%request}}',
            'id'
        );

    }

    public function down()
    {
        $this->dropTable('{{%direct}}');
        $this->dropTable('{{%photo}}');
        $this->dropTable('{{%video}}');
        $this->dropTable('{{%request}}');
    }

}
