<?php

use yii\db\Migration;

class m260907_234749_create_fotografias_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%fotografias}}', [
            'id' => $this->primaryKey(),

            'titulo' => $this->string(255)->notNull(),

            'descripcion' => $this->text(),

            'archivo' => $this->string(255)->notNull(),

            'orden' => $this->integer()->notNull()->defaultValue(0),

            'estado' => $this->smallInteger()->notNull()->defaultValue(1),

            'created_at' => $this->integer()->notNull(),

            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%fotografias}}');
    }
}