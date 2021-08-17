const Encore = require('@symfony/webpack-encore');
const {alias, assets, BUILD_TYPE} = require('./paths')

Encore
  .disableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild([
    '**/*',
    '!svg/**',
  ])
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableSassLoader()
  .autoProvidejQuery()
  .configureLoaderRule('sass', loaderRule => {
    // See: https://symfony.com/doc/current/frontend/encore/advanced-config.html#having-the-full-control-on-loaders-rules
    loaderRule.oneOf.forEach((loader, index) => {
      if (Array.isArray(loader.use)) {

        loader.use.forEach((useRule, indexUse) => {
          if (useRule.loader.indexOf('css-loader') !== -1) {
            loaderRule.oneOf[index].use[indexUse].options.url = false
          }
        })
      }
    })
  });

const getCustomConfig = (buildType, entries) => {
  process.env.BROWSERSLIST_ENV = buildType;

  Object.entries(entries).forEach(([key, value]) => {
    Encore.addEntry(key, value);
  });

  Encore
    .setOutputPath(`${assets.site.prefix}${assets.site.assets_dest}/${buildType}`)
    .setPublicPath(`${assets.site.assets_dest}/${buildType}`)
    .setManifestKeyPrefix(`${assets.site.assets_dest}/${buildType}`)

  const config = Encore.getWebpackConfig();

  config.resolve.alias = alias;

  config.optimization.splitChunks.cacheGroups = {
    commons: {
      name: 'js/vendor',
      chunks: 'initial',
      minChunks: 3
    }
  };

  config.name = buildType;

  return config;
}

module.exports = {getCustomConfig, BUILD_TYPE};
