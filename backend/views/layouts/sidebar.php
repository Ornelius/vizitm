<?php
/* @var $assetDir string */

use hail812\adminlte\widgets\Menu;
use vizitm\entities\Users;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->


    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=Html::encode($assetDir)?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= Html::encode(Yii::$app->getUser()->identity->lastname) . " " . Html::encode(Yii::$app->getUser()->identity->name)

                    ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            $position = Users::findUserByID(Yii::$app->user->getId())->position;
            $visible = false;
            if(($position === Users::POSITION_GL_INGENER) || ($position === Users::POSITION_DEGURNI_OPERATOR)) /** Елсли должность главного инженера или дежурного оператора*/
                $visible = true;
                $menu_items =  [
                    ['label' => 'Текущие заявки', 'icon' => 'newspaper', 'url' => [Url::toRoute('/request/new')]],
                    ['label' => 'Заявки в работе', 'icon' => 'wrench', 'url' => [Url::toRoute('request/work')]],
                    ['label' => 'Срочные заявки', 'icon' => ' fa-exclamation-circle', 'url' => [Url::toRoute('request/due')], 'visible' => $visible],
                    ['label' => 'Заявки в работе', 'icon' => ' fa-exclamation-circle', 'url' => [Url::toRoute('request/duework')]],
                    ['label' => 'Выполненные заявки', 'icon' => 'thumbs-up', 'url' => [Url::toRoute('request/done')]],
                ];
            $visible = false;
            if(($position === Users::POSITION_GL_INGENER) || ($position === Users::POSITION_ADMINISTRATOR ) || ($position === Users::POSITION_INGENER)) /** Елсли должность главного инженера или дежурного оператора*/
                $visible = true;
            $menu_person =  [
                ['label' => 'Подчиненные', 'icon' => 'newspaper', 'url' => [Url::toRoute('/slaves/index')]],
            ];

            echo Menu::widget([
                'items' => [
/*                    [
                        'label' => 'Настройка',
                        'icon' => 'tachometer-alt',
                        'badge' => '<span class="right badge badge-info"></span>',
                        'items' => [
                            ['label' => 'Пользователи', 'icon' => 'users', 'url' => ['/users/index']],
                            ['label' => 'Улицы', 'icon' => ' fa-street-view', 'url' => ['/street/index']],
                            ['label' => 'Дома', 'icon' => ' fa-home', 'url' => ['/building/index']],
                        ]
                    ],*/
                    [
                        'label' => 'Заявки',
                        'icon' => 'far fa-file',
                        //'badge' => '<span class="fa-file"></span>',
                        'items' => $menu_items,
                    ],
                    [
                        'label' => 'Мои подчиненные',
                        'icon' => 'fas fa-user-alt',
                        //'badge' => '<span class="fa-file"></span>',
                        'items' => $menu_person,
                        'visible' => $visible,
                    ],
/*                  ['label' => 'Simple Link', 'icon' => 'th', 'badge' => '<span class="right badge badge-danger">New</span>'],
                    ['label' => 'Yii2 PROVIDED', 'header' => true],
                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
                    ['label' => 'MULTI LEVEL EXAMPLE', 'header' => true],
                    ['label' => 'Level1'],
                    [
                        'label' => 'Level1',
                        'items' => [
                            ['label' => 'Level2', 'iconStyle' => 'far'],
                            [
                                'label' => 'Level2',
                                'iconStyle' => 'far',
                                'items' => [
                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle']
                                ]
                            ],
                            ['label' => 'Level2', 'iconStyle' => 'far']
                        ]
                    ],
                    ['label' => 'Level1'],
                    ['label' => 'LABELS', 'header' => true],
                    ['label' => 'Important', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
                    ['label' => 'Warning', 'iconClass' => 'nav-icon far fa-circle text-warning'],
                    ['label' => 'Informational', 'iconStyle' => 'far', 'iconClassAdded' => 'text-info'],*/
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>