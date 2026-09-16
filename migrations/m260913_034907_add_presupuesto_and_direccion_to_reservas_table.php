<?php

use yii\db\Migration;

/**
 * Class m260913_034907_add_presupuesto_and_direccion_to_reservas_table
 */
class m260913_034907_add_presupuesto_and_direccion_to_reservas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%reservas}}',
            'presupuesto',
            $this->string(100)->null()->after('telefono')
        );

        $this->addColumn(
            '{{%reservas}}',
            'direccion',
            $this->string(255)->null()->after('presupuesto')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%reservas}}', 'direccion');
        $this->dropColumn('{{%reservas}}', 'presupuesto');
    }
}