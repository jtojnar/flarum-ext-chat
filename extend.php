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

//use Flagrow\ImageUpload\Providers\StorageServiceProvider;
use Flarum\Extend;
use Flarum\Foundation\Application;
use Illuminate\Contracts\Events\Dispatcher;
use PushEDX\Chat\Api\Controllers\ChatMessagePostController;
use PushEDX\Chat\Api\Controllers\ChatMessageFetchController;

return [
    (new Extend\Frontend('admin'))
        ->css(__DIR__ . '/resources/less/admin/settingsPage.less')
        ->js(__DIR__ . '/js/dist/admin.js'),
    (new Extend\Frontend('forum'))
        ->css(__DIR__ . '/resources/less/forum/chat.less')
        ->js(__DIR__ . '/js/dist/forum.js'),
    new Extend\Locales(__DIR__ . '/resources/locale'),
    (new Extend\Routes('api'))
        ->post('/chat', 'pushedx.chat.post', ChatMessagePostController::class)
        ->get('/chat', 'pushedx.chat.fetch', ChatMessageFetchController::class),
];
