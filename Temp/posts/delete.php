<?php
require_once '../vendor/autoload.php';

use Helpers\Auth;
use Helpers\HTTP;
use Helpers\Helper;
use Libs\Database\Post;

$auth = Auth::check();
require_once '../layouts/header.php';
require_once '../layouts/navbar.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['post'])) :
    $slug = $_GET['post'];
    $post = Post::getPostBySlug($slug);
    !$post && HTTP::redirect('/index.php', "Unknown Request");
?>
    <!-- ======= Our Team Section ======= -->
    <section id="team" class="team">
        <div class="container">

            <div class="section-title">
                <h3>Are you sure you want to delete this post?</h3>

            </div>
            <div class="row justify-content-center">
                <div class="member col-lg-8 col-md-12">
                    <form action="<?= Helper::baseUrl() ?>/_actions/posts/delete.php" method="POST" enctype="multipart/form-data">
                        <!-- Hidden Inputs -->
                        <input type="hidden" name="id" value="<?php echo $post->id ?>">
                        <input type="hidden" name="delete" value="delete">

                        <h4 class="mb-4">"<?php echo $post->caption ?>"</h4>
                        <div class="image">
                            <img id="output" class="rounded-0" width="300" src="<?= Helper::baseUrl() ?>/assets/images/posts/<?= $post->filename ?>" />
                        </div>

                        <button type="submit" class="btn btn-danger"><i class="icofont-ui-delete"></i> Delete Post</button>
                        <small class="d-block mt-2 text-danger">Warning: This action is irreversible</small>
                    </form>
                </div>
            </div>

        </div>
    </section><!-- End Our Team Section -->




<?php
    require_once '../layouts/footer.php';
endif;
?>