<?php

use Illuminate\Database\Seeder;
use App\Category;
use Faker\Factory as Faker;
use App\Content;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =  Faker::create();
        // dd($faker);
        factory(Category::class, 10)->create()->each(function($category) use ($faker){
            $category->content()->save(new Content([
                'type' => 'audio',
                'title' => $faker->sentence,
                'content' => 'https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'
            ]));
            $category->content()->save(new Content([
                'type' => 'audio',
                'title' => $faker->sentence,
                'content' => 'https://file-examples.com/wp-content/uploads/2017/11/file_example_MP3_700KB.mp3'
            ]));
            $category->content()->save(new Content([
                'type' => 'article',
                'title' => $faker->sentence,
                'content' => $faker->paragraph
            ]));
            $category->content()->save(new Content([
                'type' => 'article',
                'title' => $faker->sentence,
                'content' => $faker->paragraph
            ]));
        });
    }
}
