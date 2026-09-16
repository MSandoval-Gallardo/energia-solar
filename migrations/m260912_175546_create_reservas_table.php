<?php

use yii\db\Migration;

class m260912_175546_create_reservas_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%reservas}}', [
            'id' => $this->primaryKey(),

            'nombre' => $this->string(150)->notNull(),

            'email' => $this->string(255)->notNull(),

            'telefono' => $this->string(30)->notNull(),

            'fecha' => $this->date()->notNull(),

            'hora' => $this->time()->notNull(),

            'mensaje' => $this->text()->null(),

            'estado' => $this->smallInteger()->notNull()->defaultValue(0),

            'created_at' => $this->dateTime()->notNull(),

            'updated_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex(
            'idx-reservas-email',
            '{{%reservas}}',
            'email'
        );

        $this->createIndex(
            'idx-reservas-fecha',
            '{{%reservas}}',
            'fecha'
        );

        $this->createIndex(
            'idx-reservas-estado',
            '{{%reservas}}',
            'estado'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%reservas}}');
    }
}