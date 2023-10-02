let mix = require("laravel-mix");
let fs = require("fs");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */
mix.autoload({});

const settings = {
  theme_folder: "web/app/themes/newtheme/",
  local_domain: "http://localhost:8888",
};

const paths = {
  input: settings.theme_folder + "assets/src/",
  output: settings.theme_folder + "assets/dist/",
  scripts: {
    input: settings.theme_folder + "assets/src/js/",
    polyfills: ".polyfill.js",
    output: settings.theme_folder + "assets/dist/js/",
  },
  styles: {
    input: settings.theme_folder + "assets/src/sass/",
    output: settings.theme_folder + "assets/dist/css/",
  },
  svgs: {
    input: settings.theme_folder + "assets/src/svg/",
    output: settings.theme_folder + "assets/dist/svg/",
  },
  copy: {
    input: settings.theme_folder + "assets/src/copy/",
    output: settings.theme_folder + "assets/dist/",
  },
  wordpress: settings.theme_folder + "**/*.php",
  stylesheet: settings.theme_folder + "**/*.html",
};

const jsPackages = [
  __dirname + "/node_modules/jquery/dist/jquery.min.js",
];

//JS FILES
let getFiles = function (dir) {
  return fs.readdirSync(dir).filter((file) => {
    return fs.statSync(`${dir}/${file}`).isFile();
  });
};

getFiles(paths.scripts.input).forEach(function (filepath) {
  const f_array = filepath.split(".");
  const ext = f_array[1];
  if (ext == "js") {
    mix.js(paths.scripts.input + filepath, paths.scripts.output);
  } else if (ext == "json") {
    mix.copy(paths.scripts.input + filepath, paths.scripts.output);
  }
});

//SASS FILES
mix.sass(paths.styles.input + "main.scss", paths.styles.output).options({
  processCssUrls: false,
});

//SVGS FOLDER
mix.copyDirectory(paths.svgs.input, paths.svgs.output);

//COPY FOLDER
// mix.copyDirectory(paths.copy.input, paths.copy.output);

//PACKAGES
mix.combine(jsPackages, paths.scripts.output + "packages.js");

/* run browsersync */
mix.browserSync({
  proxy: settings.local_domain,
  host: "https://localhost",
  port: 3000,
  files: [
    paths.styles.output + "*.css",
    paths.scripts.output + "*.js",
    paths.wordpress,
    paths.stylesheet,
  ],
});

// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.preact(src, output); <-- Identical to mix.js(), but registers Preact compilation.
// mix.coffee(src, output); <-- Identical to mix.js(), but registers CoffeeScript compilation.
// mix.ts(src, output); <-- TypeScript support. Requires tsconfig.json to exist in the same folder as webpack.mix.js
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.less(src, output);
// mix.stylus(src, output);
// mix.postCss(src, output, [require('postcss-some-plugin')()]);
// mix.browserSync('my-site.test');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.babelConfig({}); <-- Merge extra Babel configuration (plugins, etc.) with Mix's default.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.override(function (webpackConfig) {}) <-- Will be triggered once the webpack config object has been fully generated by Mix.
// mix.dump(); <-- Dump the generated webpack config object to the console.
// mix.extend(name, handler) <-- Extend Mix's API with your own components.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   globalVueStyles: file, // Variables file to be imported in every component.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   purifyCss: false, // Remove unused CSS selectors.
//   terser: {}, // Terser-specific options. https://github.com/webpack-contrib/terser-webpack-plugin#options
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });
