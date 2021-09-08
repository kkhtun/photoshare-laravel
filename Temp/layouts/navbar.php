<?php

use Helpers\Helper;
?>
<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container">

        <div class="logo float-left">
            <h1 class="text-light"><a href="/index.php"><span>PhotoShare</span></a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
        </div>
        <nav class="nav-menu float-right d-none d-lg-block">
            <ul>
                <li class=""><a href="<?= Helper::baseUrl() ?>/index.php">Home</a></li>
                <?php if (isset($auth)) : ?>
                    <li><a href="<?= Helper::baseUrl() ?>/index.php?user=<?= $auth->slug ?>">My Photos</a></li>
                    <li><a href="<?= Helper::baseUrl() ?>/posts/create.php">Create <i class="icofont-camera-alt"></i></a></li>
                <?php endif ?>
                <li class="drop-down">
                    <a href="<?= Helper::baseUrl() ?>/users/profile.php">
                        <?php
                        if (isset($auth)) {
                            echo $auth->name;
                        } else {
                            echo "Join";
                        }
                        ?>
                    </a>
                    <ul>
                        <?php if (isset($auth)) : ?>
                            <li><a href="<?= Helper::baseUrl() ?>/users/profile.php">Profile</a></li>
                            <?php if ($auth->role_value != 1) : ?>
                                <li><a href="<?= Helper::baseUrl() ?>/users/admin.php?show=users">Admin</a></li>
                            <?php endif ?>
                            <li><a href="<?= Helper::baseUrl() ?>/_actions/users/logout.php">Logout</a></li>
                        <?php else : ?>
                            <li><a href="<?= Helper::baseUrl() ?>/users/login.php">Login</a></li>
                            <li><a href="<?= Helper::baseUrl() ?>/users/register.php">Register</a></li>
                        <?php endif ?>
                    </ul>
                </li>
                <li><a href="<?= Helper::baseUrl() ?>/about/about.php">About</a></li>
            </ul>
        </nav><!-- .nav-menu -->

    </div>
</header><!-- End #header -->
<main id="main">
    <!-- Start Main Contents -->