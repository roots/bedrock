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
    var link = document.createElement("link");
    link.href = src;
    link.rel = "stylesheet";
    link.media = media;
    document.getElementsByTagName("head")[0].appendChild(link);
  }
}
