import EventPost from './EventPost';
import extractText from '../../common/utils/extractText';

/**
 * The `PostHiddenPost` component displays a discussion event post
 * indicating that a preceding post has been hidden.
 *
 * ### Props
 *
 * - All of the props for EventPost
 */
export default class PostHiddenPost extends EventPost {
  icon() {
    return 'fas fa-trash-alt';
  }

  description(data) {
    const hidden = app.translator.trans('core.forum.post_stream.post_hidden_text', data);
    const post = app.translator.trans('core.forum.post_stream.post', data);
    const url = app.translator.

    return <span>{deleted}<a href="">{post}</a></span>;
  }

  descriptionData() {
    const post = this.props.post;
    const title = post.content()['title'];

    return {
      'author': <strong className="PostHiddenPost-post">
                <a href={app.route.discussion(this.props.post.discussion, this.props.post.number)}>
                  {app.translator.trans('core.forum.post_stream.post', data)}
                </a>
              </strong>,
      'post': <strong className="PostHiddenPost-post">
                <a href={app.route.discussion(this.props.post.discussion, this.props.post.number)}>
                  {app.translator.trans('core.forum.post_stream.post', data)}
                </a>
              </strong>,

    };
  }
}
