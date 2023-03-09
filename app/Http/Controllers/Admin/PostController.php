<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; //IMPORTANTE
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\Type;
use App\Models\Technology;
use App\Models\Lead;
use App\Mail\NewContact;


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

        //METTIAMO PRIMA DEL FILL
        if($request->hasFile('cover_image')){
            
            $path = Storage::disk('public')->put('post_images',$request->cover_image);
            $form_data['cover_image'] = $path;
        }

        $newPost->fill($form_data);

        $newPost->save();

        if($request->has('technologies')){
            
            $newPost->technologies()->attach($request->technologies);
        }

        $new_lead = new Lead();
        $new_lead->title = $form_data['title'];
        $new_lead->content = $form_data['content'];
        $new_lead->slug = $form_data['slug'];

        $new_lead->save();

        Mail::to('info@boolpress.com')->send(new NewContact($new_lead));

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

        if($request->hasFile('cover_image')){
            if($post->cover_image){
                Storage::delete($post->cover_image);
            }
            
            $path = Storage::disk('public')->put('post_images',$request->cover_image);
            
            $form_data['cover_image'] = $path;
        }

        $post->update($form_data);

        if($request->has('technologies')){
            $post->technologies()->sync($request->technologies);
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
