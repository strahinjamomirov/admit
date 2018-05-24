<?php

use dektrium\user\models\User;
use yii\db\Migration;

/**
 * Class m180523_202840_add_first_admin_user
 */
class m180523_202840_add_first_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        $transaction = $this->getDb()->beginTransaction();
        $user = \Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'create',
            'email'    => 'strahinjamomirov@gmail.com',
            'username' => 'administrator',
            'password' => 'mysecret',
        ]);
        if (!$user->insert(false)) {
            $transaction->rollBack();
            return false;
        }
        $user->confirm();
        $transaction->commit();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180523_202840_add_first_admin_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180523_202840_add_first_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
