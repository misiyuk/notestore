<?php

use yii\db\Migration;

/**
 * Class m181127_230920_init_rbac
 */
class m181127_230920_init_rbac extends Migration
{
    /**
     * @return bool|void
     * @throws \Exception
     */
    public function safeUp()
    {
        /*$auth = Yii::$app->authManager;

        // добавляем разрешение "viewSaleOfferOrders"
        $viewSaleOfferOrders = $auth->createPermission('viewSaleOfferOrders');
        $viewSaleOfferOrders->description = 'View sale offer order';
        $auth->add($viewSaleOfferOrders);

        // добавляем роль "author" и даём роли разрешение "createPost"
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);

        // добавляем роль "admin" и даём роли разрешение "updatePost"
        // а также все разрешения роли "author"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author);

        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.
        $auth->assign($author, 2);
        $auth->assign($admin, 1);*/
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
