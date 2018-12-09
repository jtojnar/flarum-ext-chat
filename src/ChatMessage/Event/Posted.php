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

namespace PushEDX\Chat\ChatMessage\Event;

use PushEDX\Chat\ChatMessage\ChatMessage;
use Flarum\User\User;

class Posted
{
    /**
     * @var ChatMessage
     */
    public $message;

    /**
     * @var User
     */
    public $actor;

    /**
     * @param ChatMessage $message
     */
    public function __construct(ChatMessage $message, User $actor = null)
    {
        $this->message = $message;
        $this->actor = $actor;
    }
}
