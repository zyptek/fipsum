<?php

use yii\helpers\Html;

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <!-- Left navbar links -->
        <button class="navbar-toggler nav-link" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation" data-widget="pushmenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item">
                    <a href="<?=\yii\helpers\Url::home()?>" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Contact</a>
                </li>
                <!-- Dropdown -->
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-bs-toggle="dropdown" aria-expanded="false" class="nav-link dropdown-toggle">Dropdown</a>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="dropdown-item">Some action</a></li>
                        <li><a href="#" class="dropdown-item">Some other action</a></li>
                        <li><?= Html::a('Sign out', ['site/logout'], ['data-method' => 'post', 'class' => 'dropdown-item']) ?></li>
                        <li><hr class="dropdown-divider"></li>
                        <!-- Level two dropdown -->
                        <li class="dropdown-submenu">
                            <a id="dropdownSubMenu2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="dropdown-item">level 2</a></li>
                                <!-- Level three dropdown -->
                                <li class="dropdown-submenu">
                                    <a id="dropdownSubMenu3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-item dropdown-toggle">level 2</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" class="dropdown-item">3rd level</a></li>
                                        <li><a href="#" class="dropdown-item">3rd level</a></li>
                                    </ul>
                                </li>
                                <!-- End Level three -->
                                <li><a href="#" class="dropdown-item">level 2</a></li>
                            </ul>
                        </li>
                        <!-- End Level two -->
                    </ul>
                </li>
            </ul>

            <!-- SEARCH FORM -->
<!--
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
-->
        </div>

        <!-- Right navbar links -->
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="messagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="far fa-comments"></i>
                    <span class="badge bg-danger">3</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="messagesDropdown">
                    <li>
                        <a href="#" class="dropdown-item">
                            <div class="d-flex">
                                <img src="<?=$assetDir?>/img/user1-128x128.jpg" alt="User Avatar" class="rounded-circle me-2" width="40" height="40">
                                <div>
                                    <h6 class="dropdown-item-title">Brad Diesel <span class="badge bg-danger ms-2"><i class="fas fa-star"></i></span></h6>
                                    <p class="small">Call me whenever you can...</p>
                                    <p class="small text-muted"><i class="far fa-clock me-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a href="#" class="dropdown-item">See All Messages</a></li>
                </ul>
            </li>

            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="far fa-bell"></i>
                    <span class="badge bg-warning">15</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                    <li><span class="dropdown-item">15 Notifications</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a href="#" class="dropdown-item">4 new messages <span class="text-muted ms-auto small">3 mins</span></a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a href="#" class="dropdown-item">See All Notifications</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
            </li>
        </ul>
    </div>
</nav>