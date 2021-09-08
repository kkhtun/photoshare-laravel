<?php
require_once '../vendor/autoload.php';

use Helpers\Auth;
use Helpers\Helper;
use Helpers\HTTP;
use Libs\Database\Post;

if (Auth::isAuth()) {
    $auth = Auth::check();
}

require_once '../layouts/header.php';
require_once '../layouts/navbar.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['post'])) :
    $slug = $_GET['post'];
    $post = Post::getPostBySlug($slug);
    !$post && HTTP::redirect('/index.php', "Unknown Request");
?>
    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
        <div class="container">

            <div class="section-title">
                <h5>Photo Details</h5>
            </div>

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <img src="<?= Helper::baseUrl() ?>/assets/images/posts/<?= $post->filename ?>" class="img-fluid rounded" alt="">
                </div>
                <div class="col-lg-10 pt-4 mx-auto">
                    <h3 class="mb-2"><?= $post->caption ?></h3>
                    <div class="mb-2">
                        Author: <?= $post->author ?>
                    </div>
                    <div class="mb-2">
                        <?php foreach ($post->categories as $cat) : ?>
                            <a href="#" class="badge badge-secondary mr-1"><?= $cat->name ?></a>
                        <?php endforeach ?>
                    </div>
                    <ul>
                        <li><i class="icofont-check-circled"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
                        <li><i class="icofont-check-circled"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
                        <li><i class="icofont-check-circled"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
                    </ul>
                    <?php if (isset($auth) && $auth->id === $post->user_id) : ?>
                        <a href="<?= Helper::baseUrl() ?>/posts/edit.php?post=<?= $post->slug ?>" class="btn btn-outline-info"><i class="icofont-edit"></i> Edit</a>
                        <a href="<?= Helper::baseUrl() ?>/posts/delete.php?post=<?= $post->slug ?>" class="btn btn-outline-danger"><i class="icofont-ui-delete"></i> Delete</a>
                    <?php endif ?>
                </div>
            </div>

        </div>
    </section><!-- End About Us Section -->
<?php
    require_once '../layouts/footer.php';
endif;
?>