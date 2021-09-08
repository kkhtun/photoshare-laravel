<?php


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        factory(App\Admin::class)->create([
            "email" => "alice@gmail.com",
            "name" => "Alice"
        ]);
        factory(App\User::class)->create([
            "email" => "bob@gmail.com",
            "name" => "Bob"
        ]);
        factory(App\User::class)->create([
            "email" => "charlie@gmail.com",
            "name" => "Charlie"
        ]);

        $this->call([
            CategorySeeder::class,
            PostSeeder::class,
            CategoryPostSeeder::class
        ]);
    }
}
