<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="https://sc.fipsum.cl/images/logo.fipsum.png" alt="FIPSUM Logo" class="brand-image elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://sc.fipsum.cl/images/user160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
	            <?php
		            $user = \backend\models\Profile::find()->where(['iduser' => Yii::$app->user->id ])->one();
		        ?>
                <a href="#" class="d-block"><?= $user->name . " " . $user->lastname?></a>
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
            $session = Yii::$app->session;
            $userModules = $session->get('userModules');
 #           if(!$userModules){
				\backend\components\Helper::loadModules();
#            }
            $userModules = $session->get('userModules');
            $menuItems = [];
            foreach ($userModules as $item) {
				if($item['name'] == 'image') continue;
                $menuItems[] = [
                    'label' => $item['descrip'],
                    'url' => [$item['name']."/index"],
                    'icon' => 'th', // Aquí puedes cambiar el icono según necesites
                ];
            }
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    [
                        'label' => 'Inicio',
                        'icon' => 'tachometer-alt',
                        'badge' => '<span class="right badge badge-info">2</span>',
                        'items' => [
                            ['label' => 'Active Page', 'url' => ['site/index'], 'iconStyle' => 'far'],
                            ['label' => 'Inactive Page', 'iconStyle' => 'far'],
                        ]
                    ]
                ]
                ]);
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => $menuItems,
            ]);
            echo \hail812\adminlte\widgets\Menu::widget([ 
                'items' => [
#                    ['label' => 'Yii2 PROVIDED', 'header' => true],
                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
#                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
#                    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
#                    ['label' => 'MULTI LEVEL', 'header' => true],
#                    ['label' => 'Level1'],
#                    [
#                        'label' => 'Level1',
#                        'items' => [
#                            ['label' => 'Level2', 'iconStyle' => 'far'],
#                            [
#                                'label' => 'Level2',
#                                'iconStyle' => 'far',
#                                'items' => [
#                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
#                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
#                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle']
#                                ]
#                            ],
#                           ['label' => 'Level2', 'iconStyle' => 'far']
#                        ]
#                    ],
#                    ['label' => 'Level1'],
#                    ['label' => 'LABELS', 'header' => true],
#                    ['label' => 'Important', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
#                    ['label' => 'Warning', 'iconClass' => 'nav-icon far fa-circle text-warning'],
#                    ['label' => 'Informational', 'iconStyle' => 'far', 'iconClassAdded' => 'text-info'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>