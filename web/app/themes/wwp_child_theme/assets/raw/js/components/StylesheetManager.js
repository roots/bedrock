/**
 * Add stylesheet tag based on css vars support and build type
 */
export class StylesheetManager {
  createDynamicStylesheet(src, media, type) {
    if (type === 'modern' && window.wonderwp.FeatureDetector.has('cssVars')) {
      this.insertLinkTag(src, media)
    } else if (type === 'default' && !window.wonderwp.FeatureDetector.has('cssVars')) {
      this.insertLinkTag(src, media)
    }
  }

   insertLinkTag(src, media) {
    const link = document.createElement("link");
    link.href = src;
    link.rel = "stylesheet";
    link.media = media;

    const headElement = document.getElementsByTagName("head")[0];
    const wpCustomCssElement = document.getElementById('wp-custom-css');

    // if custom css exists, insert compiled style before custom css
    if (wpCustomCssElement) {
      headElement.insertBefore(link, wpCustomCssElement);
    } else {
      headElement.appendChild(link);
    }
  }
}
