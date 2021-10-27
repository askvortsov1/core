/**
 * The `humanTime` utility converts a date to a localized, human-readable time-
 * ago string.
 *
 * @param {Date} time
 * @return {String}
 */
export default function humanTime(time) {
  let m = moment(time);
  const now = moment();

  // To prevent showing things like "in a few seconds" due to small offsets
  // between client and server time, we always reset future dates to the
  // current time. This will result in "just now" being shown instead.
  if (m.isAfter(now)) {
    m = now;
  }

  const day = 864e5;
  const diff = m.diff(moment());
  var userLang = navigator.language || navigator.userLanguage;
  let ago = null;

  // If this date was more than a month ago, we'll show the name of the month
  // in the string. If it wasn't this year, we'll show the year as well.
  if (diff < -30 * day) {
    if (m.year() === moment().year()) {
      if (userLang == 'en-US') {
        ago = m.format('MMM D');
      } else {
        ago = m.format('D MMM');
      }
    } else {
      if (userLang == 'en-US') {
        ago = m.format('MMM D, YYYY');
      } else {
        ago = m.format('D MMM YYYY');
      }
    }
  } else {
    ago = m.fromNow();
  }

  return ago;
};
