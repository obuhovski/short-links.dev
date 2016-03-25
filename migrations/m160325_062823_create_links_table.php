<?php

use yii\db\Migration;

class m160325_062823_create_links_table extends Migration
{
    public function up()
    {
        $this->createTable('sl_link', [
            'id' => $this->primaryKey(),
            'link' => $this->string(512),
            'short_link' => $this->string(255),
            'stat_link' => $this->string(255),
        ]);
    }

    public function down()
    {
        $this->dropTable('sl_link');
    }
}
