<?php

namespace App\Livewire;

use App\Models\Gallery;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikeButton extends Component
{
    public Gallery $gallery;

    public function toggleLike(){
        if (!Auth::check()) {
            return redirect('/login')->with(
                'message', 'Kamu harus login terlebih dahulu!'
            );
        }
        $user = Auth::user();

        $liked = $user->likedGalleries()->where('gallery_id', $this->gallery->id)->exists();

        if ($liked) {
            $user->likedGalleries()->detach($this->gallery->id);
        }else{
            $user->likedGalleries()->syncWithoutDetaching($this->gallery->id);
        }

        $this->gallery->refresh();
    }
    public function render()
    {
        $user = Auth::user();
        return view('livewire.like-button', [
            'liked' => $user
                ? $user->likedGalleries()
                    ->where('gallery_id', $this->gallery->id)
                    ->exists()
                : false,
            'likesCount' => $this->gallery->likedByUsers()->count(),
        ]);
    }
}
