// Include gulp
var gulp = require('gulp'); 

// Include Our Plugins
var jshint       = require('gulp-jshint');
var sass         = require('gulp-ruby-sass');
var concat       = require('gulp-concat');
var uglify       = require('gulp-uglify');
var rename       = require('gulp-rename');
var include      = require('gulp-include');

// Merchant CSS
var CSSFiles      = 'app/assets/css/**/*.scss';

// Compile Our Sass
gulp.task('sass', function() {
    return gulp.src(CSSFiles)
        .pipe(sass({ style:'compressed' }))
        .pipe(gulp.dest('public/css'));
});

// Merchant Javascript
var JsFile     = 'app/assets/js/**/*.js',
    JsDestDir  = 'public/js';

// Lint Task
gulp.task('lint', function() {
    return gulp.src(JsFile)
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
    return gulp.src(JsFile)
        .pipe(include())
        .pipe(uglify())
        .pipe(rename('main.js'))
        .pipe(gulp.dest(JsDestDir));
});

// Watch Files For Merchant Files Changes
gulp.task('watch', function() {
    gulp.watch(JsFile, ['lint', 'scripts']);
    gulp.watch(CSSFiles,{verbose:true}, ['sass']);
});

// Default Task
gulp.task('default', ['lint', 'sass', 'scripts', 'watch']);
