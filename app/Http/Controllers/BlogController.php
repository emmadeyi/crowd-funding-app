<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Auth;
use Arr;
use Str;
use Storage;
use Purifier;
use Crypt;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        return view('backend.posts.posts', [
            'posts' => Post::orderBy('id', 'DESC')->get()
        ]);        
    }

    /**
    * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Create Post']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('posts')->with(['err-msg' => 'Access Denied!!!']);

        return view('backend.posts.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Create Post']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('posts')->with(['err-msg' => 'Access Denied!!!']);

        $this->validate($request, [
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'title' => 'required|unique:posts,title',
            'body' => 'required|min:10',
        ],
        [
            // 'thumbnail.required' => 'Enter thumbnail url',
            'title.required' => 'Enter title',
            'title.unique' => 'Blog post with same title already exist',
        ]);
        $post = new Post();
        if($request->thumbnail) $post->image = $this->storeFile($request->thumbnail, 'photos');
        $post->title = $request->title;
        $post->body = Purifier::clean($request->body);
        $post->author = auth()->user()->id;
        if($post->save()){
            $message = 'Blog post added successfully';
            return redirect()->route('posts.show', Crypt::encrypt($post->id));
        }
        $message = 'Error adding post';
        return redirect()->back()->with('error-message', $message);
    }

    public function storeFile($photo, $dir){
        $fileName = Str::random(40).'.'.$photo->getClientOriginalExtension();
        $filePath = $photo->storeAs(
            'post/'.$dir, $fileName, 'public'
        );         
        // Save image to DB
        return $filePath;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Edit Post', 'Manage Post']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('posts')->with(['err-msg' => 'Access Denied!!!']);

        $id = Crypt::decrypt($id);
        if(!Post::find($id)) return redirect()->route('posts')->with(['err-msg' => 'Invalid Request!!!']);
        
        $post = Post::find($id);
        if(!$post) return redirect()->back();
        return view('backend.posts.edit', compact([
            'post', Post::find($id),
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {// check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Edit Post', 'Manage Post']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('posts')->with(['err-msg' => 'Access Denied!!!']);

        if(!Post::find($id)) return redirect()->route('posts')->with(['err-msg' => 'Invalid Request!!!']);

        $this->validate($request, [
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'title' => 'required|unique:posts,title,'.$id,
            'body' => 'required|min:10',
        ],
        [
            // 'thumbnail.required' => 'Enter thumbnail url',
            'title.required' => 'Enter title',
            'title.unique' => 'Blog post with same title already exist',
        ]);
        $post = Post::find($id);
        if($request->thumbnail) $post->image = $this->storeFile($request->thumbnail, 'photos');
        $post->title = $request->title;
        $post->body = Purifier::clean($request->body);
        $post->author = auth()->user()->id;
        if($post->save()){
            $message = 'Blog post updated successfully';
            return redirect()->route('posts.show', Crypt::encrypt($post->id));
        }
        $message = 'Error updating post';
        return redirect()->back()->with('error-message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
