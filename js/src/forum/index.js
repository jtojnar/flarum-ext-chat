import { extend as extendPrototype } from 'flarum/extend';
import HeaderPrimary from 'flarum/components/HeaderPrimary';

import {ChatFrame} from './components/ChatFrame';
import ChatMessage from './models/ChatMessage';

import { Extend } from '@flarum/core/forum';

export const extend = [
    new Extend.Model('chat-messages', ChatMessage)
];

app.initializers.add('pushedx-realtime-chat', app => {

    var forward = [];

    extendPrototype(HeaderPrimary.prototype, 'config', function(x, isInitialized, context) {
        if (isInitialized) return;

        app.pusher.then(channels => {
            channels.main.bind('newChat', data => {
                forward.push(data);
                m.redraw();
            });

            extendPrototype(context, 'onunload', () => channels.main.unbind('newChat'));
        });

        // Just loaded? Fetch last 10 messages
        if (forward.length == 0)
        {
            console.log('Loading');
            const data = new FormData();

            app.request({
                method: 'POST',
                url: app.forum.attribute('apiUrl') + '/chat/fetch',
                serialize: raw => raw,
                data
            }).then(
                function (response) {
                    for (var i = 0; i < response.data.attributes.messages.length; ++i) {
                        forward.push(response.data.attributes.messages[i]);
                    }
                    m.redraw();
                },
                function (response) {

                }
            );
        }
    });

    /**
     * Add the upload button to the post composer.
     */
    extendPrototype(HeaderPrimary.prototype, 'items', function(items) {
        //var chatFrame = new ChatFrame();
        //var realView = chatFrame.view;
        /*
        chatFrame.view = () => {
            return realView.call(chatFrame);
        };
        */
        //status.forwardMessage = chatFrame.forwardMessage.bind(chatFrame);
        var forwarded = forward.slice(0);
        items.add('pushedx-chat-frame', m.component(new ChatFrame, {forward: forwarded}));
        forward.splice(0, forward.length);
    });
});
