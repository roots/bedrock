const Encore = require('@symfony/webpack-encore');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const {alias, assets, BUILD_TYPE} = require('./paths')

Encore
  .disableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild([
    '**/*',
    '!svg/**',
  ])
  .enableBuildNotifications()
  .enableVersioning()
  .enableSassLoader()
  .autoProvidejQuery()
  .configureLoaderRule('sass', loaderRule => {
    // See: https://symfony.com/doc/current/frontend/encore/advanced-config.html#having-the-full-control-on-loaders-rules
    loaderRule.oneOf.forEach((loader, index) => {
      if (Array.isArray(loader.use)) {

        loader.use.forEach((useRule, indexUse) => {
          if (useRule.loader.indexOf('css-loader') !== -1 && useRule.loader.indexOf('postcss-loader') === -1) {
            loaderRule.oneOf[index].use[indexUse].options.url = false
          }
        })
      }
    })
  })
  .when(process.argv.includes('--analyze'), (Encore) => Encore.addPlugin(new BundleAnalyzerPlugin()))
;

/**
 * Build custom webpack config to apply custom rules based on build type (legacy or modern)
 * See .browserlistrc for browser version for each build type
 *
 * @param buildType
 * @param entries
 */
const getCustomConfig = (buildType, entries) => {
  process.env.BROWSERSLIST_ENV = buildType;

  Object.entries(entries).forEach(([key, value]) => {
    Encore.addEntry(key, value);
  });

  let postcssPlugins = ["postcss-preset-env"];

  if (buildType === 'legacy') {
    postcssPlugins = [
      require('postcss-import'),
      require('postcss-nested'),
      require('autoprefixer')({
        grid: true,
      }),
    ];
  }

  Encore
    .setOutputPath(`${assets.site.prefix}${assets.site.assets_dest}/${buildType}`)
    .setPublicPath(`${assets.site.assets_dest}/${buildType}`)
    .setManifestKeyPrefix(`${assets.site.assets_dest}/${buildType}`)
    .enablePostCssLoader(options => {
      options.postcssOptions = {
        plugins: postcssPlugins
      };
    })
  ;

  const config = Encore.getWebpackConfig();

  config.resolve.alias = alias;

  if (!Encore.isProduction() || process.env.FORCE_SOURCEMAP === 'true') {
    // Enable file sourcemap instead of inline sourcemap
    config.devtool = 'source-map';
  }

  config.optimization.splitChunks.cacheGroups = {
    commons: {
      name: 'js/vendor',
      chunks: 'initial',
      minChunks: 3
    }
  };

  if (Encore.isProduction()) {
    config.performance = {
      hints: "error", // "error" or false are valid too
      maxEntrypointSize: 500000, // in bytes, default 250k
      maxAssetSize: 400000, // in bytes
    }
  }

  config.name = buildType;

  return config;
}

module.exports = {getCustomConfig, BUILD_TYPE};
