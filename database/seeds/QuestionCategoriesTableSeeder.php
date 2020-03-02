<?php

use Illuminate\Database\Seeder;

class QuestionCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('question_categories')->insert([
            [
                'name' => 'Lätt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Medel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Svår',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Generella',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Troslära',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bestämmelser',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Koranen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Biografi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
