<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; //IMPORTANTE
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Type;
use App\Models\Technology;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technology = Technology::all();
        return view('admin.posts.create', compact('types','technology'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $form_data = $request->validated();

        $slug = Post::generateSlug($request->title);

        $form_data['slug'] = $slug; 

        $newPost = new Post();
        $newPost->fill($form_data);

        $newPost->save();

        if($request->has('technologies')){
            
            $newPost->technologies()->attach($request->technologies);
        }

        return redirect()->route('admin.posts.index')->with('message','Progetto creato correttamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $technology = Technology::all();
        return view('admin.posts.edit', compact('post' ,'technology'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $form_data = $request->validated();

        $slug = Post::generateSlug($request->title, '-');
        $form_data['slug'] = $slug;

        $post->update($form_data);

        if($request->has('technologies')){
            $post->technologies()->synch($request->technologies);
        }
        return redirect()->route('admin.posts.index')->with('message', 'Hai modificato correttamente il progetto');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //se non abbiamo fatto come in questo caso il 'CascateOnDelete' nella migration utilizziamo questo
        //prima cancelliamo i record della tabella ponte
        $post->technologies()->sync([]);
        
        //e poi cancelliamo il post
        $post->delete();

        return redirect()->route('admin.posts.index')->with('message', 'Hai cancellato correttamente il progetto');
    }
}
