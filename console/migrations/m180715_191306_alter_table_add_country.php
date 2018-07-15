<?php

use yii\db\Migration;

/**
 * Class m180715_191306_alter_table_add_country
 */
class m180715_191306_alter_table_add_country extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `user_ip`
ADD `country` varchar(64) NULL;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180715_191306_alter_table_add_country cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180715_191306_alter_table_add_country cannot be reverted.\n";

        return false;
    }
    */
}
