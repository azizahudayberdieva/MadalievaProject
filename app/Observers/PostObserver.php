<?php

namespace App\Observers;

use App\Enums\PostStatuses;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostObserver
{
    public function saving(Post $post)
    {
        $user = Auth::user();

        $post->user_id = $user->id;

        $post->status = $user->can('publish_posts') ? PostStatuses::PUBLISHED : PostStatuses::PENDING;

        $post->saveQuietly();
    }
}
