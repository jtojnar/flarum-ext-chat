<?php

namespace PushEDX\Chat\Listeners;

use Illuminate\Contracts\Events\Dispatcher;
use Moay\Notify\Listeners\NotificationListener;
use PushEDX\Chat\Messages\ChatMessageWasPostedMessage;
use PushEDX\Chat\ChatMessage\Event\Posted as ChatMessageWasPosted;

class ChatMessageWasPostedListener extends NotificationListener
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(ChatMessageWasPosted::class, [$this, 'sendMessage']);
    }

    /**
     * Sends a message through all of the enabled connectors
     * @param  ChatMessageWasPosted $event
     * @return void
     */
    public function sendMessage(ChatMessageWasPosted $event)
    {
        if ($this->shouldTrigger($event)) {
            $message = new ChatMessageWasPostedMessage($event->message);

            foreach ($this->getConnectorsToNotify() as $connector) {
                $connector->send($message);
            }
        }
    }

    /**
     * Checks whether or not this listener should send a notification for this event
     * @param  ChatMessageWasPosted $event
     * @return boolean
     */
    public function shouldTrigger(ChatMessageWasPosted $event)
    {
        // return $this->settings->get('flarum-notify.newChatMessageEvent') === '1';
        return true;
    }
}
