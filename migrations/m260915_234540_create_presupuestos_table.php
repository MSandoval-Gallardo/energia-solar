<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%presupuestos}}`.
 */
class m260915_234540_create_presupuestos_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%presupuestos}}', [
            'id' => $this->primaryKey(),

            'codigo' => $this->string(100)->notNull()->unique(),

            'cliente' => $this->string(150)->notNull(),

            'email' => $this->string(255)->null(),

            'telefono' => $this->string(30)->null(),

            'monto_total' => $this->integer()->notNull(),

            'porcentaje_reserva' => $this->integer()->notNull()->defaultValue(50),

            'monto_reserva' => $this->integer()->notNull(),

            'estado' => $this->smallInteger()->notNull()->defaultValue(1),

            'created_at' => $this->dateTime()->notNull(),

            'updated_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex(
            'idx-presupuestos-codigo',
            '{{%presupuestos}}',
            'codigo'
        );

        $this->createIndex(
            'idx-presupuestos-estado',
            '{{%presupuestos}}',
            'estado'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%presupuestos}}');
    }
}
