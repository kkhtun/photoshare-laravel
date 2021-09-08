<?php
require_once '../vendor/autoload.php';

use Helpers\Auth;
use Helpers\Helper;

$auth = Auth::check();

require_once '../layouts/header.php';
require_once '../layouts/navbar.php';

?>
<!-- ======= Our Team Section ======= -->
<section id="team" class="team">
    <div class="container">

        <div class="section-title">
            <h2>My Profile</h2>
        </div>
        <div class="row justify-content-center">
            <div class="member col-lg-6 col-md-10 col-10">
                <?php Helper::showMessage() ?>
                <img src="https://ui-avatars.com/api/?name=<?= $auth->name ?>" alt="">
                <h4><?= $auth->name ?></h4>
                <span>Role: User</span>
                <p class="mb-4">
                    <?= $auth->email ?>
                </p>
                <div class="form-group">
                    <a href="<?= Helper::baseUrl() ?>/users/edit.php?user=<?= $auth->slug ?>&" class="btn btn-outline-dark"><i class="icofont-edit"></i>&nbsp;Edit Details</a>
                </div>
            </div>
        </div>

    </div>
</section><!-- End Our Team Section -->
<?php require_once '../layouts/footer.php'; ?>