<?php

use yii\db\Migration;

class m260906_161114_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),

            'username' => $this->string(100)->notNull()->unique(),

            'auth_key' => $this->string(64)->notNull(),

            'password_hash' => $this->string(255)->notNull(),

            'password_reset_token' => $this->string(255)->unique(),

            'email' => $this->string(255)->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),

            'created_at' => $this->integer()->notNull(),

            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}