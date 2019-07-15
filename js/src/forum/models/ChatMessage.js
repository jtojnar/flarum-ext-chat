import Model from 'flarum/Model';
import mixin from 'flarum/utils/mixin';

export default class ChatMessage extends mixin(Model, {
  message: Model.attribute('message'),
  createdAt: Model.attribute('created_at', Model.transformDate),
  userId: Model.attribute('actorId'),
}) {
  /**
   * @inheritDoc
   */
  apiEndpoint() {
    return '/chat' + (this.exists ? '/' + this.data.id : '');
  }
}
