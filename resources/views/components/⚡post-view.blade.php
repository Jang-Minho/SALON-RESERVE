<?php

use App\Models\Post;
use Livewire\Component;

new class extends Component  {

    
    public $post;
    public function mount($id){
        $this->post = Post::findOrFail($id);


    }
};
?>

<div>
    <h1>{{$post->title}}</h1>
    <p>{{$post->body}}</p>
</div>
