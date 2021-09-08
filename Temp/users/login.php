<?php
require_once '../vendor/autoload.php';

use Helpers\Helper;
use Helpers\Auth;
use Helpers\HTTP;

Auth::isAuth() && HTTP::redirect('/index.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') :
    require_once '../layouts/header.php';
    require_once '../layouts/navbar.php';
?>

    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <?php Helper::showMessage() ?>
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <form class="card-body p-5 text-center" action="<?= Helper::baseUrl() ?>/_actions/users/login.php" method="POST">

                        <h3 class="mb-5">Sign in</h3>

                        <div class="form-outline mb-4">
                            <input type="email" id="typeEmailX" name="email" class="form-control form-control-lg" placeholder="Email" />
                        </div>

                        <div class="form-outline mb-4">
                            <input type="password" id="typePasswordX" name="password" class="form-control form-control-lg" placeholder="Password" />
                        </div>

                        <hr class="my-4">
                        <input class="btn btn-primary btn-lg btn-block" type="submit" name="login" value="Login">
                        <a href="<?= Helper::baseUrl() ?>/users/register.php" class="d-block mt-4">Don't have an account?</a>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php
    require_once '../layouts/footer.php';
endif;
?>