const path = require('path');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const VersionFile = require('webpack-version-file');
const webpack = require('webpack');

var assetsFile = './assets.json';
var assets = require(assetsFile);
var versionNum = new Date().getTime();

var buildDir = assets.site.prefix + assets.site.assets_dest;

const extractSass = new ExtractTextPlugin({
    filename: '[name]'+versionNum+'.css'
});

const cleanWebpack = new CleanWebpackPlugin([
    buildDir
]);

const versionFile = new VersionFile({
    output: buildDir+'/version.php',
    templateString: '<?php return '+ versionNum +'; ?>'
});


const commonChunk = new webpack.optimize.CommonsChunkPlugin({
    name: "js/vendor",
    minChunks: Infinity,
});

const providePlugin = new webpack.ProvidePlugin({
    $: 'jquery/dist/jquery.min',
    jQuery: 'jquery/dist/jquery.min'
});


module.exports = {

    entry: {
        'js/vendor': "jquery/dist/jquery.min",
        'js/core': assets.js.core,
        'js/admin': assets.js.admin,
        'js/plugins': assets.js.plugins,
        'js/styleguide': assets.js.styleguide,
        'js/bootstrap': assets.js.bootstrap,
        'css/core': assets.css.core
    },
    devtool: 'inline-source-map',
    module: {
        rules: [
                {
                test: /\.scss$/,
                use: extractSass.extract({
                    use: [{
                        loader: "css-loader"
                    }, {
                        loader: "sass-loader", // compiles Sass to CSS
                    }],
                    // use style-loader in development
                    fallback: "style-loader"
                }),
                }
            ]
    },
    output: {
        filename:  '[name]'+versionNum+'.js',
        path: path.resolve(__dirname,buildDir )
    },
    plugins: [
        providePlugin,
        commonChunk,
        extractSass,
        cleanWebpack,
        versionFile,
    ],
    target: 'web'
};