<?php

use yii\db\Migration;

/**
 * Class m220818_154124_warehause
 */
class m220818_154124_warehause extends Migration
{

    public function up()
    {
        $this->createTable('{{%typeofcategory}}',
            [
                'id'                        => $this->primaryKey()->notNull(),
                'name'                      => $this->string(),
            ]
        );

        $this->createTable('{{%category}}',
            [
                'id'                        => $this->primaryKey()->notNull(),
                'type_id'                   => $this->integer(),
                'name'                      => $this->string(),
            ]
        );
        $this->createIndex(
        'idx-category-type_id',
        '{{%category}}',
        'type_id'
        );
        $this->addForeignKey(
            'fk-category-type_id',
            '{{%category}}',
            'type_id',
            '{{%typeofcategory}}',
            'id'
        );

        $this->createTable('{{%material}}',
            [
                'id'                        => $this->primaryKey()->notNull(),
                'category_id'               => $this->integer()->notNull(),
                'name'                      => $this->string(),
                'type'                      => $this->string(),
                'manufacture'               => $this->string(),
                'model'                     => $this->string(),
                'diameter'                  => $this->string(),
                'typeofconnection'          => $this->string(),
                'connection'                => $this->string(),
                'powervoltage'              => $this->integer(),
                'powerconnection'           => $this->string()
            ]
        );
        $this->createIndex(
            'idx-material-category_id',
            '{{%material}}',
            'category_id'
        );
        $this->addForeignKey(
            'fk-material-category_id',
            '{{%material}}',
            'category_id',
            '{{%category}}',
            'id'
        );

        $this->createTable('{{%employee}}',
            [
                'id'                => $this->primaryKey()->notNull(),
                'name'              => $this->string(),
                'middlename'        => $this->string(),
                'lastname'          => $this->string(),
                'createdate'        => $this->integer(),
            ]
        );


        $this->createTable('{{%warehouse}}',
            [
                'id'                        => $this->primaryKey()->notNull(),
                'type_id'                   => $this->integer()->notNull(),
                'category_id'               => $this->integer()->notNull(),
                'material_id'               => $this->integer()->notNull(),
                'user_id'                   => $this->integer()->notNull(),
                'createdate'                => $this->integer(),
                'mesureunit'                => $this->string(),
                'amount'                    => $this->double(),
                'removedate'                => $this->integer(),
                'removeamount'              => $this->string(),

            ]
        );
        $this->createIndex(
            'idx-warehouse-type_id',
            '{{%warehouse}}',
            'type_id'
        );
        $this->addForeignKey(
            'fk-warehouse-type_id',
            '{{%warehouse}}',
            'type_id',
            '{{%typeofcategory}}',
            'id'
        );
        $this->createIndex(
            'idx-warehouse-category_id',
            '{{%warehouse}}',
            'category_id'
        );
        $this->addForeignKey(
            'fk-warehouse-category_id',
            '{{%warehouse}}',
            'category_id',
            '{{%category}}',
            'id'
        );
        $this->createIndex(
            'idx-warehouse-material_id',
            '{{%warehouse}}',
            'material_id'
        );
        $this->addForeignKey(
            'fk-warehouse-material_id',
            '{{%warehouse}}',
            'material_id',
            '{{%material}}',
            'id'
        );


        $this->createTable('{{%outfit}}',
            [
                'id'                => $this->primaryKey()->notNull(),
                'warehouse_id'      => $this->integer()->notNull(),
                'building_id'       => $this->integer()->notNull(),
                'material_id'       => $this->integer()->notNull(),
                'employee_id'       => $this->integer()->notNull(),
                'user_id'           => $this->integer()->notNull(),
                'createdate'        => $this->integer(),
                'amount'            => $this->double()
            ]
        );
        $this->createIndex(
            'idx-outfit-warehouse_id',
            '{{%outfit}}',
            'warehouse_id'
        );
        $this->addForeignKey(
            'fk-outfit-warehouse_id',
            '{{%outfit}}',
            'warehouse_id',
            '{{%warehouse}}',
            'id'
        );
        $this->createIndex(
            'idx-outfit-building_id',
            '{{%outfit}}',
            'building_id'
        );
        $this->addForeignKey(
            'fk-outfit-building_id',
            '{{%outfit}}',
            'building_id',
            '{{%building}}',
            'id'
        );
        $this->createIndex(
            'idx-outfit-material_id',
            '{{%outfit}}',
            'material_id'
        );
        $this->addForeignKey(
            'fk-outfit-material_id',
            '{{%outfit}}',
            'material_id',
            '{{%material}}',
            'id'
        );
        $this->createIndex(
            'idx-outfit-employee_id',
            '{{%outfit}}',
            'employee_id'
        );
        $this->addForeignKey(
            'fk-outfit-employee_id',
            '{{%outfit}}',
            'employee_id',
            '{{%employee}}',
            'id'
        );


        $this->createTable('{{%warehousejur}}',
            [
                'id'                => $this->primaryKey()->notNull(),
                'warehouse_id'      => $this->integer()->notNull(),
                'user_id'           => $this->integer()->notNull(),
                'createdate'        => $this->integer(),
                'amount'            => $this->double(),
            ]
        );
        $this->createIndex(
            'idx-warehousejur-warehouse_id',
            '{{%warehousejur}}',
            'warehouse_id'
        );
        $this->addForeignKey(
            'fk-warehousejur-warehouse_id',
            '{{%warehousejur}}',
            'warehouse_id',
            '{{%warehouse}}',
            'id'
        );
        $this->createIndex(
            'idx-warehousejur-user_id',
            '{{%warehousejur}}',
            'user_id'
        );
        $this->addForeignKey(
            'fk-warehousejur-user_id',
            '{{%warehousejur}}',
            'user_id',
            '{{%users}}',
            'id'
        );




        $this->createTable('{{%outfitjur}}',
            [
                'id'                => $this->primaryKey()->notNull(),
                'outfit_id'         => $this->integer()->notNull(),
                'user_id'           => $this->integer()->notNull(),
                'createdate'        => $this->integer(),
                'amount'            => $this->double(),
            ]
        );
        $this->createIndex(
            'idx-outfitjur-outfit_id',
            '{{%outfitjur}}',
            'outfit_id'
        );
        $this->addForeignKey(
            'fk-outfitjur-outfit_id',
            '{{%outfitjur}}',
            'outfit_id',
            '{{%outfit}}',
            'id'
        );
        $this->createIndex(
            'idx-outfitjur-user_id',
            '{{%outfitjur}}',
            'user_id'
        );
        $this->addForeignKey(
            'fk-outfitjur-user_id',
            '{{%outfitjur}}',
            'user_id',
            '{{%users}}',
            'id'
        );

    }

    public function down(): bool
    {
        $this->dropTable('{{%outfitjur}}');
        $this->dropTable('{{%warehousejur}}');
        $this->dropTable('{{%outfit}}');
        $this->dropTable('{{%warehouse}}');
        $this->dropTable('{{%employee}}');
        $this->dropTable('{{%material}}');
        $this->dropTable('{{%category}}');
        $this->dropTable('{{%typeofcategory}}');
        echo "m220818_154124_warehouse deleted.\n";
        return true;
    }

}
