<?php

use yii\db\Migration;

class m261005_182811_add_presupuesto_data_to_reservas_table extends Migration
{
    public function safeUp()
    {
        // Las columnas ya existen porque fueron creadas
        // antes de que la migración fallara.

        // Índice para presupuesto_id
        $this->createIndex(
            'idx-reservas-presupuesto_id',
            '{{%reservas}}',
            'presupuesto_id'
        );

        // Relación con la tabla presupuestos
        $this->addForeignKey(
            'fk-reservas-presupuesto_id',
            '{{%reservas}}',
            'presupuesto_id',
            '{{%presupuestos}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-reservas-presupuesto_id',
            '{{%reservas}}'
        );

        $this->dropIndex(
            'idx-reservas-presupuesto_id',
            '{{%reservas}}'
        );
    }
}