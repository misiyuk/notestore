<?php

use yii\db\Migration;

/**
 * Class m181028_201928_add_admin_user
 */
class m181028_201928_add_admin_user extends Migration
{
    private $username = 'admin';
    public function up()
    {
        $this->insert('{{%user}}', [
            'id' => '1',
            'username' => $this->username,
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('08740874'),
            'email' => '6olinet@gmail.com',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    public function down()
    {
        $this->delete('{{%user}}', ['username' => $this->username]);
    }
}
