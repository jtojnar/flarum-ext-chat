<?php

/*
 * This file is part of Flarum.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PushEDX\Chat;

use Flarum\User\User;
use Illuminate\Database\Eloquent\Builder;

class ChatMessageRepository
{
    /**
     * Get a new query builder for the tags table.
     *
     * @return Builder
     */
    public function query()
    {
        return ChatMessage::query();
    }

    /**
     * Find all tags, optionally making sure they are visible to a
     * certain user.
     *
     * @param User|null $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(User $user = null)
    {
        $query = ChatMessage::query();

        return $this->scopeVisibleTo($query, $user)->get();
    }

    /**
     * Scope a query to only include records that are visible to a user.
     *
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    protected function scopeVisibleTo(Builder $query, User $user = null)
    {
        if ($user !== null) {
            $query->whereVisibleTo($user);
        }

        return $query;
    }
}
