<?php

namespace App\Http\Livewire\Blog;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Post;
use Auth;
use Arr;
use Str;
use Storage;

class CreatePost extends Component
{
    
    public $title;
    public $body;
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
        return view('livewire.blog.create-post');
    }

    public function savePost(){
        // dd($this->body, $this->title);
        $validatedData = $this->validate([
            'title' => 'required|min:3',
            // 'body' => 'required|min:10',
            'photo' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        // save the new Post model
        // or update the existing Post model with new state data
        if($this->photo) $this->filePath = $this->storeFile($this->photo, 'photos');
        $post = Post::create(['title' => $this->title, 'body' => $this->body, 'author' => Auth::user()->id, 'image' => $this->filePath]);

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

    public function resetState(){
        $this->title = null;
        $this->body = null;
        $this->photo = null;
        $this->filePath = null;
    }
}
