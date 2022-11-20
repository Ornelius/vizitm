<?php

use yii\db\Migration;
use vizitm\entities\address\Street;

/**
 * Class m210710_073926_street
 */
class m210710_073926_street extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%street}}',
            [
                'id' => $this->primaryKey(),
                'street' => $this->string()->notNull()->unique(),
            ]
        );
        $street = Street::create('Мичурина');
        if(!$street->save()) {
            throw new \RuntimeException('Street did\'t saved!');
        }

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%street}}');

    }

}
