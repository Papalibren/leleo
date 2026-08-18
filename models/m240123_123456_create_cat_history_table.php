<?php
// migrations/m240123_123456_create_cat_history_table.php

use yii\db\Migration;

class m240123_123456_create_cat_history_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('cat_history', [
            'id' => $this->primaryKey(),
            'cat_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'action' => $this->string(50)->notNull(), // create, update, status_change, etc.
            'field_name' => $this->string(100), // Название измененного поля
            'old_value' => $this->text(), // Старое значение
            'new_value' => $this->text(), // Новое значение
            'change_type' => $this->string(50), // Тип изменения
            'status' => $this->smallInteger()->defaultValue(0), // 0-не требует модерации, 1-на модерации
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'moderated_by' => $this->integer(), // Кто промодерировал
            'moderated_at' => $this->timestamp(), // Когда промодерировано
        ]);

        // Индексы
        $this->createIndex('idx-cat_history-cat_id', 'cat_history', 'cat_id');
        $this->createIndex('idx-cat_history-user_id', 'cat_history', 'user_id');
        $this->createIndex('idx-cat_history-action', 'cat_history', 'action');
        $this->createIndex('idx-cat_history-status', 'cat_history', 'status');

        // Внешние ключи
        $this->addForeignKey('fk-cat_history-cat_id', 'cat_history', 'cat_id', 'cat', 'id', 'CASCADE');
        $this->addForeignKey('fk-cat_history-user_id', 'cat_history', 'user_id', 'user', 'id', 'CASCADE');
        $this->addForeignKey('fk-cat_history-moderated_by', 'cat_history', 'moderated_by', 'user', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropTable('cat_history');
    }
}