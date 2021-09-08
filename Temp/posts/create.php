<?php

require_once '../vendor/autoload.php';

use Helpers\Auth;
use Helpers\Helper;
use Libs\Database\Category;

$auth = Auth::check();

require_once '../layouts/header.php';
require_once '../layouts/navbar.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') :
?>
    <!-- ======= Create Section ======= -->
    <section class="contact section-bg">
        <div class="container">

            <div class="section-title">
                <h2>Share a new photo</h2>
                <p>Please fill out your caption and upload a photo to start sharing. Be sure to check your details are correct.</p>
            </div>
            <?php Helper::showMessage() ?>
            <div class="row">

                <div class="col-lg-5 col-md-12">
                    <div class="contact-about">
                        <img id="output" class="w-100" />
                    </div>
                </div>

                <div class="col-lg-7 col-md-12">
                    <form action="<?= Helper::baseUrl() ?>/_actions/posts/create.php" method="POST" enctype="multipart/form-data" role="form" class="mb-4">
                        <div class="form-group">
                            <input type="text" name="caption" class="form-control p-4" placeholder="Caption" />
                        </div>
                        <div class="form-group row">
                            <?php
                            $categories = Category::getAll();
                            foreach ($categories as $cat) : ?>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <input type="checkbox" name="categories[]" value="<?= $cat->id ?>" /><span> <?= $cat->name ?></span>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Photo Upload</label>
                            <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1" onchange="loadFile(event)">
                        </div>
                        <div class="text-center">
                            <input type="submit" name="post" value="Share" class="btn btn-info w-25 rounded">
                        </div>
                    </form>
                </div>
                <script>
                    // This is to preview before upload
                    var loadFile = function(event) {
                        var output = document.getElementById('output');
                        output.src = URL.createObjectURL(event.target.files[0]);
                        output.onload = function() {
                            URL.revokeObjectURL(output.src) // free memory
                        }
                    };
                </script>
            </div>
        </div>
    </section><!-- End Create Post Section -->

<?php
endif;
require_once '../layouts/footer.php';
?>