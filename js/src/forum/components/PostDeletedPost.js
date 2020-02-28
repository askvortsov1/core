import EventPost from './EventPost';
import extractText from '../../common/utils/extractText';

/**
 * The `PostDeletedPost` component displays a discussion event post
 * indicating that a preceding post has been deleted.
 *
 * ### Props
 *
 * - All of the props for EventPost
 */
export default class PostDeletedPost extends EventPost {
  icon() {
    return 'fas fa-times';
  }

  description(data) {
    const deleted = app.translator.trans('core.forum.post_stream.post_deleted_text', data);

    return <span>{deleted}</span>;
  }

  descriptionData() {
    const post = this.props.post;
    const title = post.content()['title'];

    return {
      'title': <strong className="PostDeletedPost-title">{title}</strong>
    };
  }
}
