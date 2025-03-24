<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Article::factory()->count(10)->create();
        $articles = [
            ['title' => '記事T1', 'content' => '記事コンテンツ1'],
            ['title' => '記事T2', 'content' => '記事コンテンツ2'],
            ['title' => '記事T3', 'content' => '記事コンテンツ3'],
            ['title' => '記事T4', 'content' => '記事コンテンツ4'],
            ['title' => '記事T5', 'content' => '記事コンテンツ5'],
            ['title' => '記事T6', 'content' => '記事コンテンツ6'],
            ['title' => '記事T7', 'content' => '記事コンテンツ7'],
            ['title' => '記事T8', 'content' => '記事コンテンツ8'],
            ['title' => '記事T9', 'content' => '記事コンテンツ9'],
            ['title' => '記事T10', 'content' => '記事コンテンツ10'],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
