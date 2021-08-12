const path = require('path')
const assetsFile = '../../assets.json';
const assets = require(assetsFile);

const BUILD_TYPE = {
  LEGACY: 'legacy',
  MODERN: 'modern'
}

function getAssetsEntries(buildType) {
  const jsAssets = Object.keys(assets.js);
  const entry = {};

  jsAssets.forEach((key) => {
    const attr = 'js/' + key;

    if (buildType === BUILD_TYPE.LEGACY && key === 'critical') {
      entry[attr] = [
        `${assets.site.prefix}${assets.site.assets_src}/js/polyfill.js`,
        ...assets.js[key]
      ];
    } else {
      entry[attr] = assets.js[key];
    }
  });

  const cssAssets = Object.keys(assets.css);
  cssAssets.forEach((key) => {
    const attr = 'css/' + key;
    entry[attr] = assets.css[key];
  });

  return entry;
}

const alias = {
  "BodyMovin": path.resolve('node_modules', 'lottie-web/build/player/lottie.min.js'),
  "ScrollMagic": path.resolve('node_modules', 'scrollmagic/scrollmagic/uncompressed/ScrollMagic.js'),
  "CSSPlugin": path.resolve('node_modules', 'gsap/src/uncompressed/plugins/CSSPlugin.js'),
  "animation.gsap": path.resolve('node_modules', 'scrollmagic/scrollmagic/uncompressed/plugins/animation.gsap.js'),
  "debug.addIndicators": path.resolve('node_modules', 'scrollmagic/scrollmagic/uncompressed/plugins/debug.addIndicators.js'),
  "Barba": path.resolve('node_modules', 'barba.js/dist/barba.min.js'),
  "svg4everybody": path.resolve('node_modules', 'svg4everybody/dist/svg4everybody.min.js')
};

module.exports = {
  getAssetsEntries,
  alias,
  assets,
  BUILD_TYPE
}
