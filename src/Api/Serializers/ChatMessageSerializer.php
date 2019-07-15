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

namespace PushEDX\Chat\Api\Serializers;

use Flarum\Api\Serializer\AbstractSerializer;
use Flarum\Api\Serializer\UserSerializer;

class ChatMessageSerializer extends AbstractSerializer
{
    /**
     * {@inheritdoc}
     */
    protected function getDefaultAttributes($message)
    {
        $attributes = [
            'message' => $message->message,
            'createdAt' => $this->formatDate($message->created_at),
        ];

        return $attributes;
    }

   /**
    * @return \Tobscure\JsonApi\Relationship
    */
   protected function user($message)
   {
       return $this->hasOne($message, UserSerializer::class);
   }
}
