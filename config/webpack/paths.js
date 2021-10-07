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
        ...Object.values(assets.js[key])
      ];
    } else {
      entry[attr] = Object.values(assets.js[key]);
    }
  });

  const cssAssets = Object.keys(assets.css);
  cssAssets.forEach((key) => {
    const attr = 'css/' + key;
    entry[attr] = Object.values(assets.css[key]);
  });

  return entry;
}

const alias = {
  "ScrollMagic": path.resolve('node_modules', 'scrollmagic/scrollmagic/uncompressed/ScrollMagic.js'),
  "debug.addIndicators": path.resolve('node_modules', 'scrollmagic/scrollmagic/uncompressed/plugins/debug.addIndicators.js'),
};

module.exports = {
  getAssetsEntries,
  alias,
  assets,
  BUILD_TYPE
}
