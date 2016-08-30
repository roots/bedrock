'use strict';

var gulp = require('gulp');
var gutil = require('gulp-util');
var sass = require('gulp-sass');
var rename = require("gulp-rename");
var map = require("map-stream");
var livereload = require("gulp-livereload");
var uglify = require('gulp-uglify');
var watch = require('gulp-watch');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var svgSprite = require('gulp-svg-sprite');

var sassGraph = require('sass-graph');

var fs = require('fs');
global.errorMessage = '';

//Recuperation du fichier d'assets
var assetsFile = './assets.json';
var assets = require(assetsFile);
var assetsAssoc = {};
var date = new Date();

//Configuration des différents modules gulp
var config = {
    versionNum: 1,//date.getTime(),
    sass: {
        output: assets.site.prefix + assets.site.assets_dest + '/css/',
        compilerOptions: {
            outputStyle: assets.site.env=='development' ? 'nested' : 'compressed'
        }
    },
    svgSprites: {
        src: assets.site.prefix + assets.site.assets_src + '/svg/*.svg',
        compilerOptions: {
            shape				: {
                dimension		: {			// Set maximum dimensions
                    maxWidth	: 128,
                    maxHeight	: 128
                },
                spacing			: {			// Add padding
                    padding		: 5
                }
            },
            mode: {
                view: {			// Activate the «view» mode
                    bust: false,
                    render: {
                        scss: true		// Activate Sass output (with default options)
                    }
                },
                symbol: false
            },
        },
        dest: assets.site.prefix + assets.site.assets_dest+'/svg/'
    },
    autoPrefixr: {}
};

//======================================================================================//

gulp.task('write-version', function () {
    var versionContent = '<?php return ' + config.versionNum + '; ?>';
    return string_src('version.php', versionContent)
        .pipe(gulp.dest(assets.site.prefix + assets.site.assets_dest))
});
gulp.task('watch', function () {

    gulp.start('write-version');

    //Watch assets defined in json files
    for (var i in assets.css) {
        var sassData = {
            name: i,
            files: assets.css[i],
            watchers: [],
            output: config.sass.output,
            destName: i + config.versionNum + '.css'
        }
        for(var j in assets.css[i]) {
            var deps = sassGraph.parseFile(assets.css[i][j]);
            for (var k in deps.index) {
                sassData.watchers.push(k);
            }
        }
        sassWatch(sassData);
    }

    gulp.start('watch-styleguide');


});
gulp.task('default', ['watch']);

gulp.task('watch-styleguide',function(){
    //Watch styleguide
    var styleguideSassData = {
        name: 'styleguide',
        files: [assets.site.prefix + assets.site.assets_src+'/../../styleguide/scss/main.scss'],
        watchers: [],
        output: assets.site.prefix + assets.site.assets_src+'/../../styleguide/css/',
        destName: 'main.css'
    }
    for(var j in styleguideSassData.files) {
        var deps = sassGraph.parseFile(styleguideSassData.files[j]);
        for (var k in deps.index) {
            styleguideSassData.watchers.push(k);
        }
    }
    sassWatch(styleguideSassData);
});

gulp.task('svg-sprites', function () {
    var svgSrc = config.svgSprites.src,
        svgDest = config.svgSprites.dest
    console.log('Getting svgs from ' + svgSrc);
    console.log('And trying to write to ' + svgDest);
    gulp.src(svgSrc)
        .pipe(svgSprite(config.svgSprites.compilerOptions))
        .pipe(gulp.dest(svgDest));
});

gulp.task('test',function(){
    //var file = assets.css['app'][2];
    var file = './web/app/themes/wwp_child_theme/styleguide/scss/atoms/_chapo.scss';
});


function sassWatch(sassData) {
    gulp.src(sassData.files)
        .pipe(watch(sassData.watchers, {}, function (file) {
            if (file && file.basename) {
                console.log(file.basename + ' has been changed. Compiling ' + sassData.name + ' group');
            }
            sassCompile(sassData);
        }));
}
function sassCompile(sassData) {
    var groupScssContent = '';
    for (var i in sassData.files) {
        groupScssContent += '@import "' + sassData.files[i] + '";' + "\n";
    }
    return string_src(sassData.name + '.scss', groupScssContent)
    //.pipe(gulp.dest(config.sass.output))
        .pipe(sourcemaps.init())
        .pipe(sass(config.sass.compilerOptions))
        .pipe(autoprefixer(config.autoPrefixr))
        .pipe(sourcemaps.write())
        .on('error', function (err) {
            gutil.log(err.message);
            gutil.beep();
            global.errorMessage = err.message + " ";
        })
        .pipe(checkErrors())
        .pipe(rename(sassData.destName))
        .pipe(gulp.dest(sassData.output))
        .pipe(livereload());
}

function string_src(filename, string) {
    var src = require('stream').Readable({objectMode: true})
    src._read = function () {
        this.push(new gutil.File({cwd: "", base: "", path: filename, contents: new Buffer(string)}))
        this.push(null)
    }
    return src;
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

/*function getGroupFromFile(fileSrc){
 if(assetsAssoc[fileSrc]){ return assetsAssoc[fileSrc]; }

 var assetType = (fileSrc.indexOf('.js')>=0) ? 'js' : 'css';
 for(var i in assets[assetType]){
 if(assets[assetType][i].indexOf(fileSrc)>=0){
 var thisGroup = {
 name: i,
 file: assets[assetType][i]
 }
 assetsAssoc[fileSrc] = thisGroup;
 console.log(thisGroup);
 return thisGroup;
 }
 }
 }*/