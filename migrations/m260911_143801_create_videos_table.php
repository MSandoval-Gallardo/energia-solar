<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%videos}}`.
 */
class m260911_143801_create_videos_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%videos}}', [
            'id' => $this->primaryKey(),
            'titulo' => $this->string(255)->notNull(),
            'descripcion' => $this->text(),
            'url' => $this->string(500)->notNull(),
            'miniatura' => $this->string(500),
            'orden' => $this->integer()->notNull()->defaultValue(0),
            'estado' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%videos}}');
    }
}