const path = require('path');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const VersionFile = require('webpack-version-file');
const webpack = require('webpack');
const CopyWebpackPlugin = require('copy-webpack-plugin');

let assetsFile = './assets.json';
let assets = require(assetsFile);
let versionNum = new Date().getTime();
let buildDir = assets.site.prefix + assets.site.assets_dest;

const extractSass = new ExtractTextPlugin({
    filename: '[name]'+versionNum+'.css'
});

const cleanWebpack = new CleanWebpackPlugin([
    buildDir+'/js',
    buildDir+'/css'
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
    $: 'jquery',
    jQuery: 'jquery'
});

const copyPlugin = new CopyWebpackPlugin([
    {
        from: 'critical/critical.js',
        to: path.resolve(__dirname,buildDir + '/js/critical'+ versionNum + '.js' )
    }
]);

const entry = getAssetsEntries();

module.exports = {
    entry: entry,
    devtool: 'inline-source-map',
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: [
                    /node_modules(?!\/pewjs)/,
                ],
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['babel-preset-es2015-ie']
                    }
                }
            },

            {
                test: /\.scss$/,
                use: extractSass.extract({
                    use: [{
                        loader: "css-loader?url=false"
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
        copyPlugin,
        providePlugin,
        commonChunk,
        extractSass,
        cleanWebpack,
        versionFile,

    ],
    resolve: {
        alias: {
            jquery: "jquery/src/jquery"
        }
    },
    target: 'web'
};


function getAssetsEntries() {
    let jsAssets = Object.keys(assets.js);
    let entry = {};

    jsAssets.forEach((key) => {
        if(key !== 'critical') { // critical.js is manually copied in dist
            let attr = 'js/'+key;
            entry[attr] = assets.js[key];
        }
    });

    let cssAssets = Object.keys(assets.css);
    cssAssets.forEach((key) => {
        let attr = 'css/'+key;
        entry[attr] = assets.css[key];
    });

    return entry;
}