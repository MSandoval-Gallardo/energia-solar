
<?php

use yii\db\Migration;

class m261011_232049_create_pagos_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%pagos}}', [
            'id' => $this->primaryKey(),
            'reserva_id' => $this->integer()->notNull(),
            'orden_compra' => $this->string(100)->notNull()->unique(),
            'token_transbank' => $this->string(255)->null(),
            'monto' => $this->integer()->notNull(),
            'estado' => $this->string(30)->notNull()->defaultValue('iniciado'),
            'codigo_autorizacion' => $this->string(100)->null(),
            'tipo_pago' => $this->string(50)->null(),
            'fecha_pago' => $this->dateTime()->null(),
            'respuesta_transbank' => $this->text()->null(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex(
            'idx-pagos-reserva_id',
            '{{%pagos}}',
            'reserva_id'
        );

        $this->createIndex(
            'idx-pagos-estado',
            '{{%pagos}}',
            'estado'
        );

        $this->addForeignKey(
            'fk-pagos-reserva_id',
            '{{%pagos}}',
            'reserva_id',
            '{{%reservas}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-pagos-reserva_id',
            '{{%pagos}}'
        );

        $this->dropTable('{{%pagos}}');
    }
}