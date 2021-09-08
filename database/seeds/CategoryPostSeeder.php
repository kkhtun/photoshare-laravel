<?php


use Illuminate\Database\Seeder;
use App\Category;
use App\Post;
use App\CategoryPost;

class CategoryPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $categories = Category::paginate(5);
        $posts = Post::paginate(5);

        foreach ($posts as $post) {
            foreach ($categories as $cats) {
                CategoryPost::firstOrCreate([
                    'category_id' => rand(1, count($categories)),
                    'post_id' => $post->id,
                ]);
            }
        }
    }
}
