const path                    = require('path');
const CleanWebpackPlugin      = require('clean-webpack-plugin');
const MiniCssExtractPlugin    = require('mini-css-extract-plugin');
const VersionFile             = require('webpack-version-file');
const webpack                 = require('webpack');
const CopyWebpackPlugin       = require('copy-webpack-plugin');
const WebpackBarPlugin        = require('webpackbar');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const TerserJSPlugin          = require('terser-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');

let assetsFile = './assets.json';
let assets     = require(assetsFile);
let versionNum = new Date().getTime();
let buildDir   = assets.site.prefix + assets.site.assets_dest;

const MiniCssExtract = new MiniCssExtractPlugin({
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

const providePlugin = new webpack.ProvidePlugin({
    $: 'jquery',
    jQuery: 'jquery',
    'window.jQuery': 'jquery'
});

const copyPlugin = new CopyWebpackPlugin([
    {
        from: 'web/app/themes/wwp_child_theme/assets/raw/js/app_init.js',
        to: path.resolve(__dirname, buildDir + '/js/init' + versionNum + '.js')
    }
]);

const webpackBarPlugin = new WebpackBarPlugin();

const entry = getAssetsEntries();

module.exports = (env) => {
    env = env || 'development';

    let config = {
        mode: env,
        stats: "minimal",
        target: 'web',
        devtool: env === 'production' ? 'none' : 'source-map',

        entry: entry,

        output: {
            filename: '[name]' + versionNum + '.js',
            path: path.resolve(__dirname, buildDir)
        },

        module: {
            rules: [
                {
                    "test": /\.js$/,
                    "exclude": /node_modules/,
                    "use": {
                        "loader": "babel-loader",
                        "options": {
                            "presets": [
                                "env"
                            ]
                        }
                    }
                },
                {
                    test: /\.(sa|sc|c)ss$/,
                    "use": [
                        {
                            // After all CSS loaders we use plugin to do his work.
                            // It gets all transformed CSS and extracts it into separate
                            // single bundled file
                            loader: MiniCssExtractPlugin.loader
                        },
                        {
                            loader: 'css-loader',
                            options: {
                                url: false,
                                sourceMap: (env !== 'production')
                            }
                        }, {
                            loader: "postcss-loader", options: {
                                sourceMap: (env !== 'production'),
                            }
                        },
                        {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: (env !== 'production'),
                            }
                        }
                    ]
                },
                {
                    // Now we apply rule for images
                    test: /\.(png|jpe?g|gif|svg)$/,
                    use: [
                        {
                            // Using file-loader for these files
                            loader: "file-loader"
                        }
                    ]
                },
                {
                    // Apply rule for fonts files
                    test: /\.(woff|woff2|ttf|otf|eot)$/,
                    use: [
                        {
                            // Using file-loader too
                            loader: "file-loader"
                        }
                    ]
                }
            ]
        },

        optimization: {
            splitChunks: {
                cacheGroups: {
                    commons: {
                        name: 'js/vendor',
                        chunks: 'initial',
                        minChunks: 3
                    }
                }
            }
        },

        plugins: [
            copyPlugin,
            cleanWebpack,
            versionFile,
            providePlugin,
            MiniCssExtract,
            //new BundleAnalyzerPlugin(),
            webpackBarPlugin
        ],

        resolve: {
            alias: {
                jquery: "jquery/dist/jquery.min.js",
                "TweenLite": path.resolve('node_modules', 'gsap/src/uncompressed/TweenLite.js'),
                "TweenMax": path.resolve('node_modules', 'gsap/src/uncompressed/TweenMax.js'),
                "BodyMovin": path.resolve('node_modules', 'lottie-web/build/player/lottie.min.js'),
                "TimelineLite": path.resolve('node_modules', 'gsap/src/uncompressed/TimelineLite.js'),
                "TimelineMax": path.resolve('node_modules', 'gsap/src/uncompressed/TimelineMax.js'),
                "ScrollMagic": path.resolve('node_modules', 'scrollmagic/scrollmagic/uncompressed/ScrollMagic.js'),
                "CSSPlugin": path.resolve('node_modules', 'gsap/src/uncompressed/plugins/CSSPlugin.js'),
                "animation.gsap": path.resolve('node_modules', 'scrollmagic/scrollmagic/uncompressed/plugins/animation.gsap.js'),
                "debug.addIndicators": path.resolve('node_modules', 'scrollmagic/scrollmagic/uncompressed/plugins/debug.addIndicators.js'),
                //  "velocity": path.resolve('web', 'app/themes/wwp_child_theme/styleguide/atomic-core/js/velocity.js'), // Uncomment only for Atomic-Core build use
                "barba": path.resolve('node_modules', 'barba.js/dist/barba.min.js')

            }
        }
    };

    if (env === 'production') {
        config['optimization']['minimizer'] = [
            new TerserJSPlugin({}), new OptimizeCSSAssetsPlugin({})
        ];
    }

    return config;
};

function getAssetsEntries() {
    let jsAssets = Object.keys(assets.js);
    let entry    = {};

    jsAssets.forEach((key) => {
        if (key !== 'init') { // is manually copied in dist
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
