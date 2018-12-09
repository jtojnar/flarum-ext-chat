<?php

namespace PushEDX\Chat\Messages;

use Moay\Notify\Messages\Message as NotifyMessage;
use PushEDX\Chat\ChatMessage\ChatMessage;

class ChatMessageWasPostedMessage extends NotifyMessage
{
    /**
     * @param ChatMessage $message
     */
    public function __construct(ChatMessage $message)
    {
        $this->message = $message;
        $this->prepareMessage();
    }

    /**
     * Prepares the message which should be sent to the Connectors
     * @return void
     */
    public function prepareMessage()
    {
        $this->author = $this->message->actor;
        $this->message = 'posted in the chat: “' . htmlspecialchars($this->message->message) . '”';
        $this->short = 'New chat message';
        $this->color = 'blue';

        $this->addLinkToParse('@'.$this->author->username, app('flarum.config')['url']."/u/{$this->author->id}");
    }
}
