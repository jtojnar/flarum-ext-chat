<?php
/*
 * This file is part of push-edx/flarum-ext-restricted-reply.
 *
 * Copyright (c) gpascualg.
 *
 * http://pushedx.net
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PushEDX\Chat;

use Carbon\Carbon;
use Flarum\User\User;
use Flarum\Database\AbstractModel;

/**
 * @property int $id
 *
 * @property string $message
 *
 * @property int|null $user_id
 * @property User|null $user
 *
 * @property Carbon $created_at
 */
class ChatMessage extends AbstractModel
{
    protected $table = 'pushedx_messages';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at'];

    /**
     * Create a new message.
     *
     * @param string $message
     * @param User $user
     * @param Carbon $createdAt
     */
    public static function build($message, User $user, Carbon $createdAt)
    {
        $msg = new static;

        $msg->message = $message;
        $msg->actor_id = $user->id;
        $msg->created_at = $createdAt;

        return $msg;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
