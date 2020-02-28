<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Post;

use Flarum\Event\ConfigurePostTypes;
use Flarum\Foundation\AbstractServiceProvider;

class PostServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        CommentPost::setFormatter($this->app->make('flarum.formatter'));

        $this->registerPostTypes();

        $events = $this->app->make('events');
        $events->subscribe(PostPolicy::class);

        $events->listen(
            Event\Deleted::class, [PostModerationLogger::class, 'deleted']
        );
        $events->listen(
            Event\Hidden::class, [PostModerationLogger::class, 'hidden']
        );
        $events->listen(
            Event\Restored::class, [PostModerationLogger::class, 'restored']
        );
    }

    public function registerPostTypes()
    {
        $models = [
            CommentPost::class,
            DiscussionRenamedPost::class,
            PostDeletedPost::class,
            PostHiddenPost::class,
            PostRestoredPost::class
        ];

        $this->app->make('events')->fire(
            new ConfigurePostTypes($models)
        );

        foreach ($models as $model) {
            Post::setModel($model::$type, $model);
        }
    }
}
