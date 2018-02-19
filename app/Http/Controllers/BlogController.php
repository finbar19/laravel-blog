<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use App\Category;
use App\User;
use App\Tag;

class BlogController extends Controller
{
    public $limit = 3;
    public function index() {
      $posts = Post::with('author', 'tags', 'category')
                    ->latestFirst()
                    ->published()
                    ->filter(request('term'))
                    ->simplePaginate($this->limit);
      return view("blog.index", compact('posts'));
    }

    public function category(Category $category)
    {
      $categoryName = $category->title;

      $posts = $category->posts()
                       ->with('author', 'tags')
                       ->latestFirst()
                       ->published()
                       ->simplePaginate($this->limit);

      return view("blog.index", compact('posts', 'categoryName'));
    }

    public function tag(Tag $tag)
    {
      $tagName = $tag->title;

      $posts = $tag->posts()
                       ->with('author', 'category')
                       ->latestFirst()
                       ->published()
                       ->simplePaginate($this->limit);

      return view("blog.index", compact('posts', 'tagName'));
    }

    public function author(User $author)
    {
      $authorName = $author->name;

      $posts = $author->posts()
                        ->with('category', 'tags')
                        ->latestFirst()
                        ->published()
                        ->simplePaginate($this->limit);

       return view("blog.index", compact('posts', 'authorName'));
    }
    /**
     * add count to the post when vieved
     * @param $post
     * @return int +1
     */
    public function show(Post $post)
    {
        $post->increment('view_count');
        return view("blog.show", compact('post'));
    }
}
