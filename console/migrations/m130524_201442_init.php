<?php

use yii\db\Migration;
use vizitm\entities\Users;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->defaultValue(null),
            'name'  => $this->string(255),
            'middlename'  => $this->string(255),
            'lastname'  => $this->string(255),
            'position' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(Users::STATUS_ACTIVE),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'role'       => $this->integer(),
            'verification_token' => $this->string()->defaultValue(null),
        ], $tableOptions);

        $user = Users::signup('admin', '','Daewoo120482');
        if(!$user->save()) {
            throw new \RuntimeException('User did\'t saved!');
        }

    }

    public function down()
    {
        $this->dropTable('{{%users}}');
    }
}
