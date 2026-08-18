<?php
// migrations/m240123_123457_create_cat_moderation_table.php

use yii\db\Migration;

class m240123_123457_create_cat_moderation_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('cat_moderation', [
            'id' => $this->primaryKey(),
            'cat_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'data_before' => $this->json(), // Данные до изменения (JSON)
            'data_after' => $this->json(), // Данные после изменения (JSON)
            'changes_summary' => $this->text(), // Текстовое описание изменений
            'status' => $this->smallInteger()->defaultValue(0), // 0-на модерации, 1-принято, 2-отклонено
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'moderated_by' => $this->integer(), // Кто промодерировал
            'moderated_at' => $this->timestamp(), // Когда промодерировано
        ]);

        // Индексы
        $this->createIndex('idx-cat_moderation-cat_id', 'cat_moderation', 'cat_id');
        $this->createIndex('idx-cat_moderation-user_id', 'cat_moderation', 'user_id');
        $this->createIndex('idx-cat_moderation-status', 'cat_moderation', 'status');

        // Внешние ключи
        $this->addForeignKey('fk-cat_moderation-cat_id', 'cat_moderation', 'cat_id', 'cat', 'id', 'CASCADE');
        $this->addForeignKey('fk-cat_moderation-user_id', 'cat_moderation', 'user_id', 'user', 'id', 'CASCADE');
        $this->addForeignKey('fk-cat_moderation-moderated_by', 'cat_moderation', 'moderated_by', 'user', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropTable('cat_moderation');
    }
}