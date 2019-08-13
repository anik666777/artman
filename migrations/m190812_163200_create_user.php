<?php

use yii\db\Migration;

/**
 * Class m190812_163200_create_user
 */
class m190812_163200_create_user extends Migration
{
    private $_tableName = '{{%user}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->_tableName, [
            'id' => $this->primaryKey(),
            'username' => $this->string(25)->notNull()->unique(),
            'name' => $this->string(45)->notNull(),
            'last_name' => $this->string(45)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'is_online' => $this->smallInteger()->notNull()->defaultValue(1),
            'date_created' => $this->date(),
            'date_updated' => $this->date(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->_tableName);
    }
}
