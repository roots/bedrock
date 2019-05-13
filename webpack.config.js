const path               = require('path');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin  = require("extract-text-webpack-plugin");
const VersionFile        = require('webpack-version-file');
const webpack            = require('webpack');
const CopyWebpackPlugin  = require('copy-webpack-plugin');
const WebpackBarPlugin   = require('webpackbar');

let assetsFile = './assets.json';
let assets     = require(assetsFile);
let versionNum = new Date().getTime();
let buildDir   = assets.site.prefix + assets.site.assets_dest;

const extractSass = new ExtractTextPlugin({
    filename: '[name]' + versionNum + '.css'
});

const cleanWebpack = new CleanWebpackPlugin([
    buildDir + '/js',
    buildDir + '/css'
]);

const versionFile = new VersionFile({
    output: buildDir + '/version.php',
    templateString: '<?php return ' + versionNum + '; ?>'
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
        to: path.resolve(__dirname, buildDir + '/js/critical' + versionNum + '.js')
    }
]);

const webpackBarPlugin = new WebpackBarPlugin();

const entry = getAssetsEntries();

module.exports = (env) => {
    env = env || 'development';

    return {
        entry: entry,
        devtool: 'source-map',
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
                    exclude: /node_modules/,
                    use: extractSass.extract({
                        fallback: 'style-loader',
                        use: [
                            {
                                loader: 'css-loader',
                                options: {
                                    url: false,
                                    sourceMap: (env!=='production'),
                                    //minimize: true
                                }
                            }, {
                                loader: "postcss-loader", options: {
                                    sourceMap: (env!=='production'),
                                }
                            },
                            {
                                loader: 'sass-loader',
                                options: {
                                    sourceMap: (env!=='production'),
                                }
                            }
                        ]
                    })
                }

            ]
        },
        output: {
            filename: '[name]' + versionNum + '.js',
            path: path.resolve(__dirname, buildDir)
        },
        plugins: [
            copyPlugin,
            providePlugin,
            commonChunk,
            extractSass,
            cleanWebpack,
            versionFile,
            webpackBarPlugin
        ],
        resolve: {
            alias: {
                jquery: "jquery/src/jquery",
                "TweenLite": path.resolve('node_modules', 'gsap/src/uncompressed/TweenLite.js'),
                "TweenMax": path.resolve('node_modules', 'gsap/src/uncompressed/TweenMax.js'),
                "BodyMovin": path.resolve('node_modules', 'lottie-web/build/player/lottie.min.js'),
                "TimelineLite": path.resolve('node_modules', 'gsap/src/uncompressed/TimelineLite.js'),
                "TimelineMax": path.resolve('node_modules', 'gsap/src/uncompressed/TimelineMax.js'),
                "ScrollMagic": path.resolve('node_modules', 'scrollmagic/scrollmagic/uncompressed/ScrollMagic.js'),
                "animation.gsap": path.resolve('node_modules', 'scrollmagic/scrollmagic/uncompressed/plugins/animation.gsap.js'),
                "debug.addIndicators": path.resolve('node_modules', 'scrollmagic/scrollmagic/uncompressed/plugins/debug.addIndicators.js'),
                //  "velocity": path.resolve('web', 'app/themes/wwp_child_theme/styleguide/atomic-core/js/velocity.js'), // Uncomment only for Atomic-Core build use
                "barba": path.resolve('node_modules', 'barba.js/dist/barba.min.js')

            }
        },
        stats: "minimal",
        target: 'web'
    }
};

function getAssetsEntries() {
    let jsAssets = Object.keys(assets.js);
    let entry    = {};

    jsAssets.forEach((key) => {
        if (key !== 'critical') { // critical.js is manually copied in dist
            let attr    = 'js/' + key;
            entry[attr] = assets.js[key];
        }
    });

    let cssAssets = Object.keys(assets.css);
    cssAssets.forEach((key) => {
        let attr    = 'css/' + key;
        entry[attr] = assets.css[key];
    });

    /**
     * If you plan to rebuild Atomic Core component package :
     * 1- Uncomment from #ATOMIC BUILD BEGIN to #ATOMIC BUILD END below. Also uncomment "Velocity" in the webpack config alias list
     * 2- run the following npm command : "npm run build"
     * 3- Copy files from assets/final/js : atomic<versionNum>.js, vendor<versionNum>.js, core<versionNum>.js and bootstrap<versionNum>.js to /web/app/wwp_child_theme/styleguide/atomic-core/js/build
     * 3b - Do the same with .map.js file, especially if you need some debug
     * 4- rename all 4 (or 8, with map files) files and remove <versionNum>. Ex : vendor.js, boostrap.js ....
     * 5- Recomment code, recomment "Velocity"
     */
    // #ATOMIC BUILD BEGIN
    /*let atomicAssets = [
        'js/prism.js',
        'js/spectrum-picker.js',
        'js/uncomment.js',
        'js/prism-builder.js',
        'js/velocity.js',
        'js/velocity-ui.js',
        'js/_expand-form.js',
        'js/_sidebar-show-hide.js',
        'js/formShowHide.js',
        'js/slideAnimation.js',
        'js/_actionDrawer.js',
        'js/hideAll.js',
        'js/hideCode.js',
        'js/hideNotes.js',
        'js/hideTitle.js',
        'js/navSmall.js',
        'js/animateHeight.js'
    ];

    let atomic = [];
    atomicAssets.forEach(( val ) => {
        atomic.push( './web/app/themes/wwp_child_theme/styleguide/atomic-core/' + val );
    });
    entry['js/atomic'] = atomic;*/
    // #ATOMIC BUILD END

    return entry;
}
