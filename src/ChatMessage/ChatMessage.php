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

namespace PushEDX\Chat\ChatMessage;

use Carbon\Carbon;
use Flarum\User\User;
use Flarum\Database\AbstractModel;
use Flarum\Foundation\EventGeneratorTrait;
use PushEDX\Chat\ChatMessage\Event\Posted as ChatMessageWasPosted;

/**
 * @property int        $id
 *
 * @property string     $message
 *
 * @property int        $actorId
 * @property User       $actor
 *
 * @property Carbon     $created_at
 */
class ChatMessage extends AbstractModel
{
    use EventGeneratorTrait;

    protected $table = 'pushedx_messages';

    /**
     * Create a new message.
     *
     * @param string $message
     * @param User $user
     * @param Carbon $created_at
     */
    public static function build(string $message, User $user, Carbon $created_at)
    {
        $msg = new static;

        $msg->message = $message;
        $msg->actorId = $user->id;
        $msg->created_at = $created_at;

        $msg->raise(new ChatMessageWasPosted($msg));

        return $msg;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actor()
    {
        return $this->belongsTo(User::class, 'actorId');
    }
}
