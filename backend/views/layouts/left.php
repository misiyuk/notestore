<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Аранжировки', 'icon' => 'file-code-o', 'url' => ['arrangement/list']],
                    ['label' => 'Нотные наборы', 'icon' => 'file-code-o', 'url' => ['note-pack/list']],
                    ['label' => 'Заказы', 'icon' => 'file-code-o', 'url' => ['order/list']],
                    ['label' => 'Исполнители', 'icon' => 'file-code-o', 'url' => ['artist/list']],
                    ['label' => 'Композиции', 'icon' => 'file-code-o', 'url' => ['song/list']],
                    ['label' => 'Купленые ноты', 'icon' => 'file-code-o', 'url' => ['sale-offer-order/list']],
                    [
                        'label' => 'Списки',
                        'icon' => 'file-code-o',
                        'items' => [

                            ['label' => 'Жанры', 'icon' => 'file-code-o', 'url' => ['genre/list']],
                            ['label' => 'Форматы', 'icon' => 'file-code-o', 'url' => ['formats/list']],
                            ['label' => 'Типы предложений', 'icon' => 'file-code-o', 'url' => ['offer-type/list']],
                            ['label' => 'Типы аранжировок', 'icon' => 'file-code-o', 'url' => ['arrangement-type/list']],
                            ['label' => 'Сущности предложений', 'icon' => 'file-code-o', 'url' => ['offer-entity/list']],
                            ['label' => 'Фильмы', 'icon' => 'file-code-o', 'url' => ['film/list']],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
