<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    public $post;
    public $liked;
    public $likes;

    public function mount()
    {
        $this->liked = $this->post->likedBy(auth()->user());
        $this->likes = $this->post->likes()->count();
    }

    public function like()
    {
        // ? Check if the post is already liked by the user
        if ($this->post->likedBy(auth()->user())) {
            // ? If so then delete the like
            $this->post->likes()->where('user_id', auth()->id())->delete();

            // ? Update the liked property
            $this->liked = false;
            $this->likes--;
        } else {
            // ? If not then create a new like
            $this->post->likes()->create([
                'user_id' => auth()->id()
            ]);

            // ? Update the liked property
            $this->liked = true;
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
