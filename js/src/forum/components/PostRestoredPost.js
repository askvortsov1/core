import EventPost from './EventPost';
import extractText from '../../common/utils/extractText';

/**
 * The `PostRestoredPost` component displays a discussion event post
 * indicating that a preceding post has been rsestored.
 *
 * ### Props
 *
 * - All of the props for EventPost
 */
export default class PostRestoredPost extends EventPost {
  icon() {
    return 'fas fa-undo';
  }

  description(data) {
    const deleted = app.translator.trans('core.forum.post_stream.post_restored_text', data);

    return <span>{deleted}</span>;
  }

  descriptionData() {
    const post = this.props.post;
    const title = post.content()['title'];

    return {
      'title': <strong className="PostRestoredPost-title">{title}</strong>
    };
  }
}
