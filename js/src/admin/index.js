import { extend } from 'flarum/extend';
import app from 'flarum/app';
import saveSettings from 'flarum/utils/saveSettings';
import PermissionGrid from 'flarum/components/PermissionGrid';
import { NotifyPage } from '@manelizzard-notify';

app.initializers.add('pushedx-realtime-chat', app => {
    // add the permission option to the relative pane
    extend(PermissionGrid.prototype, 'startItems', items => {
        items.add('realtimeChat', {
            icon: 'weixin',
            label: 'Realtime Chat',
            permission: 'pushedx.chat.post'
        });
    });

    console.log(NotifyPage);

    extend(NotifyPage.prototype, 'eventItems', items => {
        items.add('newChatMessageEvent', {
            name: 'newChatMessageEvent',
            label: app.translator.trans('pushedx-chat.admin.notify_events.chat_message_posted')
        });
    });
});
