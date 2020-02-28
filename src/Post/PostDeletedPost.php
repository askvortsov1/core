<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Post;

use Carbon\Carbon;

/**
 * A post which indicates that a discussion's title was changed.
 *
 * The content is stored as a sequential array containing the old title and the
 * new title.
 */
class PostDeletedPost extends AbstractEventPost implements MergeableInterface
{
    /**
     * {@inheritdoc}
     */
    public static $type = 'postDeleted';


    /**
     * Save the model, given that it is going to appear immediately after the
     * passed model.
     *
     * @param Post|null $previous
     *
     * @return Post The resulting event post.
     */
    public function saveAfter(Post $previous = null)
    {
        $this->save();

        return $this;
    }

    /**
     * Create a new instance in reply to a discussion.
     *
     * @param int $discussionId
     * @param int $userId
     * @param string $content
     * @return static
     */
    public static function reply($discussionId, $userId, $content)
    {
        $post = new static;

        $post->content = static::buildContent($content);
        $post->created_at = Carbon::now();
        $post->discussion_id = $discussionId;
        $post->user_id = $userId;
        $post->is_mod_only = true;

        return $post;
    }

    /**
     * Build the content attribute.
     *
     * @param string $content The content of the deleted post.
     * @return array
     */
    protected static function buildContent($content)
    {
        return ['content' => $content];
    }
}
