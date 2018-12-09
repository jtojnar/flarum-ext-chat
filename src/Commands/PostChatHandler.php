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

namespace PushEDX\Chat\Commands;

use Carbon\Carbon;
//use Flagrow\ImageUpload\Contracts\UploadAdapterContract;
//use Flagrow\ImageUpload\Events\ImageWillBeSaved;
//use Flagrow\ImageUpload\Image;
//use Flagrow\ImageUpload\Validators\ImageValidator;
use PushEDX\Chat\Api\Controllers\FetchChatController;
use Flarum\User\AssertPermissionTrait;
use Flarum\Post\PostRepository;
use Flarum\User\UserRepository;
use Flarum\Foundation\DispatchEventsTrait;
use Flarum\Foundation\Application;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Pusher;
use PushEDX\Chat\ChatMessage\ChatMessage;

class PostChatHandler
{
    use DispatchEventsTrait;
    use AssertPermissionTrait;

    /**
     * @var UserRepository
     */
    protected $users;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @param Dispatcher                  $events
     * @param UserRepository              $users
     * @param UploadAdapterContract       $upload
     * @param PostRepository              $posts
     * @param Application                 $app
     * @param ImageValidator              $validator
     * @param SettingsRepositoryInterface $settings
     */
    public function __construct(
        Dispatcher $events,
        UserRepository $users,
        PostRepository $posts,
        Application $app,
        SettingsRepositoryInterface $settings
    ) {
        $this->events    = $events;
        $this->users     = $users;
        $this->posts     = $posts;
        $this->app       = $app;
        $this->settings  = $settings;
    }

    /**
     * Handles the command execution.
     *
     * @param UploadImage $command
     * @return null|string
     *
     * @todo check permission
     */
    public function handle(PostChat $command)
    {
        // check if the user can upload images, otherwise return
        $this->assertCan(
            $command->actor,
            'pushedx.chat.post'
        );

        $message = ChatMessage::build(
            $command->msg,
            $command->actor,
            new Carbon
        );

        $message->save();

        $pusher = $this->getPusher();
        $pusher->trigger('public', 'newChat', $message->toArray());

        $this->dispatchEventsFor($message, $command->actor);

        $message->save();

        return $command->msg;
    }

    /**
     * @return Pusher
     */
    protected function getPusher()
    {
        return new Pusher(
            $this->settings->get('flarum-pusher.app_key'),
            $this->settings->get('flarum-pusher.app_secret'),
            $this->settings->get('flarum-pusher.app_id'),
            ['cluster' => $this->settings->get('flarum-pusher.app_cluster')]
        );
    }
}
