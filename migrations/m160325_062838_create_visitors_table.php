<?php

use yii\db\Migration;

class m160325_062838_create_visitors_table extends Migration
{
    public function up()
    {
        $this->createTable('sl_visitor', [
            'id' => $this->primaryKey(),
            'link_id' => $this->integer(11),
            'ip' => $this->string(31),
            'date' => $this->dateTime(),
            'region' => $this->string(255),
            'browser' => $this->string(255),
            'os' => $this->string(255),
        ]);

        $this->createIndex('idx-link_id', 'sl_visitor', 'link_id');
        $this->addForeignKey('fk-link_id', 'sl_visitor', 'link_id', 'sl_link', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('sl_visitor');
    }
}
