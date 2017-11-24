'use strict';

var gulp = require('gulp');
var gutil = require('gulp-util');
var map = require("map-stream");
var uglify = require('gulp-uglify');
var watch = require('gulp-watch');
var sourcemaps = require('gulp-sourcemaps');
var concat = require('gulp-concat');
var path = require('path');
var glob = require('glob');
var fs = require('fs');
var gulpSequence = require('gulp-sequence');

//======================================================================================//
//Config
//======================================================================================//

global.errorMessage = '';

//Recuperation du fichier d'assets
var assetsFile = './assets.json';
var assets = require(assetsFile);
var date = new Date();
var isDev = assets.site.env == 'development';

//Configuration des différents modules gulp
var config = {
    isDev: isDev,
    versionNum: date.getTime(),
    sass: {
        output: assets.site.prefix + assets.site.assets_dest + '/css/',
        compilerOptions: {
            outputStyle: isDev ? 'nested' : 'compressed'
        }
    },
    js: {
        output: assets.site.prefix + assets.site.assets_dest + '/js/'
    },
    svgSprites: {
        src: assets.site.prefix + assets.site.assets_src + '/svg/*.svg',
        compilerOptions: {
            shape: {
                dimension: {			// Set maximum dimensions
                    maxWidth: 128,
                    maxHeight: 128
                },
                spacing: {			// Add padding
                    padding: 5
                }
            },
            mode: {
                view: {			// Activate the «view» mode
                    bust: false,
                    render: {
                        scss: true		// Activate Sass output (with default options)
                    }
                },
                symbol: true
            },
        },
        dest: assets.site.prefix + assets.site.assets_dest + '/svg/'
    },
    autoPrefixr: {}
};

//======================================================================================//
//Tasks
//======================================================================================//


gulp.task('watch-styleguide', function () {
    sassWatch(getStyleGuideSassData());
    jsWatch(getStyleGuideJsData());
});
gulp.task('build-styleguide-sass', function () {
    //console.log('build-styleguide-sass');
    var thisPipe = sassCompile(getStyleGuideSassData());
    //console.log('end-build-styleguide-sass');
    return thisPipe;
});
gulp.task('build-styleguide-js', function () {
    //console.log('build-styleguide-js');
    var thisPipe = jsCompile(getStyleGuideJsData());
    //console.log('end-build-styleguide-js');
    return thisPipe;
});


gulp.task('build-others', function () {
    //console.log('build-others');
    //Watch assets defined in json files
    //console.log('build-others-sass');
    var sassDatas = getSassDatas();
    for (var i in sassDatas) {
        sassCompile(sassDatas[i]);
    }
    //console.log('build-others-js');
    var jsDatas = getJsDatas();
    for (var i in jsDatas) {
        jsCompile(jsDatas[i]);
    }
    //console.log('end-build-others');
});

gulp.task('build',   gulpSequence('write-version', 'svg-sprites', ['build-styleguide-sass', 'build-styleguide-js'],'build-others'));
gulp.task('default', gulpSequence('build', ['watch-styleguide', 'watch']));

//======================================================================================//
// Functions
//======================================================================================//




function getJsDatas() {
    var jsDatas = [];
    for (var i in assets.js) {
        var jsData = {
            name: i,
            files: assets.js[i],
            watchers: assets.js[i],
            output: config.js.output,
            destName: i + config.versionNum + '.js'
        }

        jsDatas.push(jsData);
    }
    return jsDatas;
}

function getStyleGuideJsData() {
    //Watch styleguide JS
    var styleGuideJsFolder = assets.site.prefix + assets.site.assets_src + '/../../styleguide/js',
        jsFilesDefinitionAsJson = styleGuideJsFolder + '/js.json',
        jsFilesDefinition = require(jsFilesDefinitionAsJson),
        jsFiles = [];

    var cpt = 0;
    for (var componentName in jsFilesDefinition) {
        for (var fileName in jsFilesDefinition[componentName]) {
            jsFiles[cpt] = path.resolve(styleGuideJsFolder + '/components/' + componentName + '/' + jsFilesDefinition[componentName][fileName]);
            cpt++;
        }
    }

    var styleguideJsData = {
        name: 'styleguide',
        files: jsFiles,
        watchers: jsFiles,
        output: path.resolve(assets.site.prefix + assets.site.assets_src + '/../../styleguide/js/compiled') + '/',
        destName: 'styleguide.js'
    }
    return styleguideJsData;
}

function jsWatch(jsData) {

    return gulpSrc(jsData.files)
        .pipe(watch(jsData.watchers, {}, function (file) {
            if (file && file.basename) {
                console.log(file.basename + ' has been changed. Compiling ' + jsData.name + ' group');
                jsCompile(jsData);
            }
        }));
}

function jsCompile(jsData) {
    //Delete previous versions
    var oldVersions = jsData.output+jsData.name+'*.js';
    glob(oldVersions,function(err,files){
        if (err) throw err;
        // Delete files
        files.forEach(function(item,index,array){
            fs.unlink(item, function(err){
                if (err) throw err;
            });
        });
    });

    if (!isDev) {
        return gulpSrc(jsData.files)
            .pipe(sourcemaps.init())
            .pipe(concat(jsData.destName))
            .pipe(uglify())
            .pipe(sourcemaps.write('./'))
            .pipe(gulp.dest(jsData.output));
    } else {
        return gulpSrc(jsData.files)
            .pipe(concat(jsData.destName))
            .pipe(gulp.dest(jsData.output));
    }
}


function string_src(filename, string) {
    var src = require('stream').Readable({objectMode: true})
    src._read = function () {
        this.push(new gutil.File({cwd: "", base: "", path: filename, contents: new Buffer(string)}))
        this.push(null)
    }
    return src;
}

function gulpSrc(paths) {
    paths = (paths instanceof Array) ? paths : [paths];
    var existingPaths = paths.filter(function (path) {
        if (glob.sync(path).length === 0) {
            console.log(path + ' doesnt exist');
            return false;
        }
        return true;
    });
    return gulp.src((paths.length === existingPaths.length) ? paths : []);
}

// Does pretty printing of sass errors
var checkErrors = function (obj) {
    function checkErrors(file, callback, errorMessage) {
        if (file.path.indexOf('.scss') != -1) {
            file.contents = new Buffer("\
					body * { white-space:pre; }\
					body * { display: none!important; }\
					body:before {\
						white-space:pre;\
						content: '" + global.errorMessage.replace(/(\\)/gm, "/").replace(/(\r\n|\n|\r)/gm, "\\A") + "';\
					}\
					html{background:#ccf!important; }\
				");
        }
        callback(null, file);
    }

    return map(checkErrors);
};