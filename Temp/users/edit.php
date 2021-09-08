<?php
require_once '../vendor/autoload.php';

use Helpers\Auth;
use Helpers\Helper;
use Helpers\HTTP;
use Libs\Database\User;

$auth = Auth::check();

require_once '../layouts/header.php';
require_once '../layouts/navbar.php';

if (isset($_GET['user'])) {
    $slug = $_GET['user'];
    $user = User::userBySlug($slug);
    if ($auth->role_value == 1) {
        $user->id !== $auth->id &&
            HTTP::redirect('/users/profile.php', 'Unknown Request');
    }
}
// Helper::echoArr($_GET);
if (!$user) {
    HTTP::redirect('/users/profile.php', 'Unknown Request');
}
?>
<!-- ======= Our Team Section ======= -->
<div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <?php Helper::showMessage() ?>
            <div class="card shadow-2-strong" style="border-radius: 1rem;">
                <form class="card-body p-5 text-center" action="<?= Helper::baseUrl() ?>/_actions/users/update.php" method="POST">

                    <h3 class="mb-5">Edit User Details</h3>

                    <!-- Hidden Inputs -->
                    <input type="hidden" name="id" value="<?= $user->id ?>">
                    <div class="form-outline mb-4">
                        <input type="email" id="typeEmailX" name="email" class="form-control form-control-lg" placeholder="Email" value="<?= $user->email ?>" />
                    </div>
                    <div class="form-outline mb-4">
                        <input type="text" id="typeNameX" name="name" class="form-control form-control-lg" placeholder="Username" value="<?= $user->name ?>" />
                    </div>
                    <hr class="mt-4">
                    <p>Leave the password fields blank if you do not wish to change the password</p>
                    <div class="form-outline mb-4">
                        <input type="password" id="typePasswordX" name="password" class="form-control form-control-lg" placeholder="Type here to change password" />
                    </div>
                    <div class="form-outline mb-4">
                        <input type="password" id="typePasswordX" name="confirm_password" class="form-control form-control-lg" placeholder="Confirm password change" />
                    </div>

                    <hr class="my-4">
                    <input class="btn btn-primary btn-lg btn-block" type="submit" name="update" value="Update User">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- <div class="row justify-content-center">
            <div class="member col-lg-6 col-md-10 col-10">
                <img src="https://ui-avatars.com/api/?name=<?= $auth->name ?>" alt="">
                <h4><?= $auth->name ?></h4>
                <span>Role: User</span>
                <p>
                    <?= $auth->email ?>
                </p>
            </div>
        </div> -->
<?php require_once '../layouts/footer.php'; ?>