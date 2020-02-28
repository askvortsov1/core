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
class PostHiddenPost extends AbstractEventPost implements MergeableInterface
{
    /**
     * {@inheritdoc}
     */
    public static $type = 'postHidden';


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
     * @param int $postNumber
     * @param int $authorId
     * @return static
     */
    public static function reply($discussionId, $userId, $postNumber, $authorId)
    {
        $post = new static;

        $post->content = static::buildContent($postNumber, $authorId);
        $post->created_at = Carbon::now();
        $post->discussion_id = $discussionId;
        $post->user_id = $userId;
        $post->is_mod_only = true;

        return $post;
    }

    /**
     * Build the content attribute.
     *
     * @param int $postNumber The number of the post in the thread.
     * @param int $authorId: the ID of the post's author.
     * @return array
     */
    protected static function buildContent($postNumber, $authorId)
    {
        return [
            'postNumber' => $postNumber,
            'authorId' => $authorId
        ];
    }
}
