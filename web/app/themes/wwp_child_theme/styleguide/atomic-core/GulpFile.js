var gulp = require('gulp');
var sass = require('gulp-sass');

var order = require("gulp-order");
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');


gulp.task('styles', function() {
    gulp.src('scss/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./css/'));
});

var jsFiles = 'js/*.js',
    jsDest = 'js/min';

gulp.task('scripts', function() {
    return gulp.src('js/*.js')
        .pipe(order([
            'js/bootstrap.min.js',
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
        ], { base: './' }))
        .pipe(concat('compiled.js'))
        .pipe(gulp.dest(jsDest))
        .pipe(rename('compiled.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(jsDest));
});

//Watch task
gulp.task('default',function() {
    gulp.watch('scss/**/*.scss',['styles']);
    gulp.watch('js/*.js',['scripts']);
});

gulp.task('setup', ['styles']);
