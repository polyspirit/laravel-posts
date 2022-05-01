<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->success(Post::all(), 'Posts were showed');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = '';
        if ($request->hasFile('file')) {
            $path = Storage::disk('public')->put(
                'posts',
                $request->file('file')
            );
        }

        $fields = array_merge(
            $request->all(),
            ['user_id' => auth()->user()->id, 'image' => $path]
        );
        unset($fields['file']);
        $post = Post::create($fields);

        return $this->success($post, 'Post was created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if ($request->input('like')) {
            $this->tryToCreateLike($post);
        }

        $post->update($request->all());

        return $this->success($post, 'Post was updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    private function tryToCreateLike(Post $post): void
    {
        $userId = auth()->user()->id;
        $like = Like::where('user_id', '=', $userId)->where('post_id', '=', $post->id)->first();
        if ($like) {
            $like->delete();
        } else {
            $fields = ['post_id' => $post->id, 'user_id' => $userId];
            $like = Like::create($fields);
        }
    }
}
