<?php

namespace App\Http\Controllers;

use App\Models\Post;

use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
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
        Post::create($postField);

        return ["post created" => $postField];
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
      $post->delete();
      return 'post deleted' ;
    }
}
