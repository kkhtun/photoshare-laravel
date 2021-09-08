<?php
require_once '../vendor/autoload.php';

use Helpers\Helper;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();
if ($auth->role_value == 1) {
    HTTP::redirect('/index.php', "Unauthorized");
}

if (isset($_GET['show'])) {
    $show = $_GET['show'];
    in_array($show, ['users', 'posts']) ?? HTTP::redirect('/404.php', 'Unknown Request');
    $show === "" && HTTP::redirect('/404.php', 'Unknown Request');
} else {
    HTTP::redirect('/404.php', 'Unknown Request');
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') :
    require_once '../layouts/header.php';
    require_once '../layouts/navbar.php';
?>
    <link rel="stylesheet" href="<?= Helper::baseUrl() ?>/assets/css/sidebar.css">
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">Admin Panel</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3 <?= $show === 'users' ? 'active' : '' ?>" href="<?= Helper::baseUrl() ?>/users/admin.php?show=users&">
                    <i class="icofont-user"></i>&nbsp;Users</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3 <?= $show === 'posts' ? 'active' : '' ?>" href="<?= Helper::baseUrl() ?>/users/admin.php?show=posts&">
                    <i class="icofont-ui-image"></i>&nbsp;Posts</a>
            </div>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">Toggle Sidebar</button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Dropdown
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            <li class="nav-item active"><a class="nav-link" href="#!">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="#!">Link</a></li>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content-->
            <div class="container-fluid">
                <?php Helper::showMessage() ?>
                <?php if (isset($show) && $show === 'users') {
                    require_once 'admin/users.php';
                }
                ?>
            </div>
        </div>
    </div>
    <script src="<?= Helper::baseUrl() ?>/assets/js/sidebar.js"></script>
<?php
    require_once '../layouts/footer.php';
endif;
?>