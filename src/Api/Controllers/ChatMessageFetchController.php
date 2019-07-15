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

namespace PushEDX\Chat\Api\Controllers;

use Carbon\Carbon;
use PushEDX\Chat\Api\Serializers\ChatMessageSerializer;
use PushEDX\Chat\ChatMessage;
use PushEDX\Chat\ChatMessageRepository;
use PushEDX\Chat\Commands\FetchChat;
use PushEDX\Chat\Message;
use Flarum\Api\Controller\AbstractShowController;
use Illuminate\Contracts\Bus\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ChatMessageFetchController extends AbstractShowController
{

    /**
     * The serializer instance for this request.
     *
     * @var ChatMessageSerializer
     */
    public $serializer = ChatMessageSerializer::class;

    /**
     * {@inheritdoc}
     */
    public $include = [
        'user',
    ];

    /**
     * {@inheritdoc}
     */
    public $sortFields = ['-created_at'];

    /**
     * @var Dispatcher
     */
    protected $bus;

    /**
     * @var ChatMessageRepository
     */
    protected $messages;

    /**
     * @param Dispatcher $bus
     * @param ChatMessageRepository $messages
     */
    public function __construct(Dispatcher $bus, ChatMessageRepository $messages)
    {
        $this->bus = $bus;
        $this->messages = $messages;
    }

    // static public function GetMessages($id = null)
    // {
    //     if ($id === null)
    //     {
    //         $msgs = Message::query()->orderBy('id', 'desc')->limit(20);
    //     }
    //     else
    //     {
    //         $msgs = Message::query()->where('id', '<', $id)->orderBy('id', 'desc')->limit(20);
    //     }

    //     return $msgs->get()->reverse();
    // }

    // static public function UpdateMessages($msg)
    // {
    //     $message = Message::build(
    //         $msg['message'],
    //         $msg['actorId'],
    //         new Carbon
    //     );

    //     $message->save();

    //     return $message->id;
    // }

    /**
     * Get the data to be serialized and assigned to the response document.
     *
     * @param ServerRequestInterface $request
     * @param Document               $document
     * @return mixed
     */
    // protected function data(ServerRequestInterface $request, Document $document)
    // {
    //     if (isset($request->getParsedBody()['id'])) {
    //         $id = $request->getParsedBody()['id'];
    //         $msgs = ChatMessageFetchController::GetMessages($id);
    //     } else {
    //         $msgs = ChatMessageFetchController::GetMessages();
    //     }

    //     return $this->bus->dispatch(
    //         new FetchChat($msgs)
    //     );
    // }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $actor = $request->getAttribute('actor');
        $include = $this->extractInclude($request);

        $messages = $this->messages->get();

        return $messages->load($include);
    }
}
