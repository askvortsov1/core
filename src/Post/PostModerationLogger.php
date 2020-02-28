<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Post;

class PostModerationLogger
{
    public function deleted(Event\Deleted $event)
    {
        $post = PostDeletedPost::reply(
            $event->post->discussion->id,
            $event->actor->id,
            $event->post->title
        );

        $post = $event->post->discussion->mergePost($post);
    }

    public function restored(Event\Restored $event)
    {
        $post = PostRestoredPost::reply(
            $event->post->discussion->id,
            $event->actor->id,
            $event->post->number,
            $event->post->user_id,
        );

        $post = $event->post->discussion->mergePost($post);
    }

    public function hidden(Event\Hidden $event)
    {
        $post = PostHiddenPost::reply(
            $event->post->discussion->id,
            $event->actor->id,
            $event->post->number,
            $event->post->user_id,
        );

        $post = $event->post->discussion->mergePost($post);
    }
}
