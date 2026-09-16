<?php

use yii\db\Migration;

class m260912_021200_create_proyectos_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%proyectos}}', [
            'id' => $this->primaryKey(),

            'titulo' => $this->string(255)->notNull(),

            'descripcion' => $this->text()->null(),

            'imagen' => $this->string(255)->null(),

            'orden' => $this->integer()->notNull()->defaultValue(0),

            'estado' => $this->smallInteger()->notNull()->defaultValue(1),

            'created_at' => $this->dateTime()->notNull(),

            'updated_at' => $this->dateTime()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%proyectos}}');
    }
}