<?php

use yii\db\Migration;

/**
 * Class m260915_023751_add_monto_reserva_to_reservas_table
 */
class m260915_023751_add_monto_reserva_to_reservas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%reservas}}',
            'monto_reserva',
            $this->integer()->null()->after('direccion')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%reservas}}', 'monto_reserva');
    }
}