<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    //
        // 記事一覧表示
        public function index()
        {
            $articles = Article::latest()->take(10)->get(); // 最新10件を取得
            return view('admin.dashboard', compact('articles'));
        }
    
        // 記事投稿処理
        public function store(Request $request)
        {
            $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
            ]);
    
            Article::create($request->all());
    
            return redirect()->route('admin.dashboard')->with('success', '記事を投稿しました！');
        }
}
