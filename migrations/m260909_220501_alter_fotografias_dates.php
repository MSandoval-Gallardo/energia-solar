<?php

use yii\db\Migration;

class m260909_220501_alter_fotografias_dates extends Migration
{
    public function safeUp()
    {
        $this->alterColumn(
            '{{%fotografias}}',
            'created_at',
            $this->dateTime()->notNull()
        );

        $this->alterColumn(
            '{{%fotografias}}',
            'updated_at',
            $this->dateTime()->notNull()
        );
    }

    public function safeDown()
    {
        $this->alterColumn(
            '{{%fotografias}}',
            'created_at',
            $this->integer()->notNull()
        );

        $this->alterColumn(
            '{{%fotografias}}',
            'updated_at',
            $this->integer()->notNull()
        );
    }
}