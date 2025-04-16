<?php

namespace App\Http\Controllers;

use App\Models\Post;

use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller implements HasMiddleware
{

     public static function middleware()
     {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
        ];
     }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ["all postes" => Post::all()];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $postField =  $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);
        $Post = $request->user()->posts()->create($postField);

        return ["post created" => $Post];
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return [ "post" =>   $post];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
         Gate::authorize('modify', $post);
        $postField =  $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);
        $post->update($postField);
        
        return ["post updated" => $postField];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('modify', $post);
         
      $post->delete();
      return 'post deleted' ;
    }
}
