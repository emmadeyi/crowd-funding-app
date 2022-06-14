<?php

namespace App\Http\Livewire\Blog;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Post;
use Auth;
use Arr;
use Str;
use Storage;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithFileUploads;
    use WithPagination;

    // public $posts;
    public $showPostsModal = false;
    public $post_id = null;
    public $postModalTitle = null;
    public $title;
    public $body;
    public $deletePostModal = false;
    public $updatePostStatusModal = false;
    public $photo = null;
    public $filePath = null;

    protected $listeners = ['fileUpload' => 'handleFileUpload'];

    protected $rules = [
        'title' => 'required|min:3',
        'body' => 'required|min:10',
        'photo' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
    ];

    public function render()
    {
        return view('livewire.blog.posts', [            
            'posts' => Post::orderBy('id', 'DESC')->paginate(10)
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function savePost(){// check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Create Post', 'Manage Post']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('posts')->with(['err-msg' => 'Access Denied!!!']);
        // dd($this->body, $this->title);
        // validate fields
        // $validatedData = $this->validate();
        $validatedData = $this->validate([
            'title' => 'required|min:3',
            'body' => 'required|min:10',
            'photo' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        // save the new Post model
        // or update the existing Post model with new state data
        if($this->post_id){
            // Update
            if($this->photo) $this->filePath = $this->storeFile($this->photo, 'photos');
            // if($filePath)ProjectPhoto::create(['url' => $filePath, 'project_id' => $project->id]);
            // $post = Post::find($this->post_id)->update(Arr::only($validatedData, ['title', 'body']));
            $post = Post::find($this->post_id)->update(['title' => $this->title, 'body' => $this->body, 'image' => $this->filePath]);
        }else{
            // dd(Auth::user()->id);
            // save
            if($this->photo) $this->filePath = $this->storeFile($this->photo, 'photos');
            $post = Post::create(['title' => $this->title, 'body' => $this->body, 'author' => Auth::user()->id, 'image' => $this->filePath]);
        }

        if($post){
            $this->posts = Post::all();
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Post added successfully.']);
        }else{
            $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while submitting post']);
        }
        $this->resetState();
    }

    public function storeFile($photo, $dir){
        $fileName = Str::random(40).'.'.$photo->getClientOriginalExtension();
        $filePath = $photo->storeAs(
            'post/'.$dir, $fileName, 'public'
        );         
        // Save image to DB
        return $filePath;
    }

    public function editPost(Post $post){// check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Edit Post', 'Manage Post']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('posts')->with(['err-msg' => 'Access Denied!!!']);
        $this->post_id = $post->id;
        $this->title = $post->title;
        $this->body = $post->body;
        $this->postModalTitle = "Update - ". $post->title;
        $this->showPostsModal = true;
    }

    public function deletePost(Post $post){
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Delete Post']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('posts')->with(['err-msg' => 'Access Denied!!!']);

        $post = Post::find($this->post_id);
        // dd($post);
        if($post->delete()){
            if(Storage::disk('public')->exists($post->image)){
                Storage::disk('public')->delete($post->image);
            }
            $this->posts = Post::all();
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Post deleted successfully.']);
        }else{
            $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred while deleting post']);
        }
        $this->resetState();
    }

    public function confirmDeletePost(Post $post){// check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Delete Post']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('posts')->with(['err-msg' => 'Unauthorized Action!!!']);

        $this->post_id = $post->id;
        $this->deletePostModal = true;
    }

    public function confirmUpdatePostStatus(Post $post){
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Manage Post']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('posts')->with(['err-msg' => 'Unauthorized Action!!!']);

        $this->post_id = $post->id;
        $this->updatePostStatusModal = true;
    }
    
    public function updatePostStatus(Post $post){  
        $post = Post::find($this->post_id);
        if($post){
            $post->status = !$post->status;
            $post->update();
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Post status updated successfully.']);
            $this->resetState();
        } else $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Error occurred updating Post Status']);     
    }

    public function resetState(){
        $this->showPostsModal = false;
        $this->deletePostModal = false;
        $this->updatePostStatusModal = false;
        $this->post_id = null;
        $this->title = null;
        $this->body = null;
        $this->rich_body = null;
        $this->photo = null;
        $this->filePath = null;
    }
}