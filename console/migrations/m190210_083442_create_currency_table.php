<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%currency}}`.
 */
class m190210_083442_create_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%currency}}', [
            'id' => $this->primaryKey(),
            'num_code' => $this->integer()->notNull()->comment('id Валюты во внешней системе'),
            'name' => $this->string(255)->notNull()->comment('Название валюты'),
            'rate' => $this->money()->notNull()->comment('Курс валюты к рублю'),
            'updated_at' => $this->dateTime()->notNull()->comment('Время последнего обновления'),
        ]);
        $this->createIndex("idx-currency-num_code", '{{%currency}}', 'num_code');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%currency}}');
    }
}
