// include gulp
var gulp = require('gulp');

// include plug-ins
var jshint          = require('gulp-jshint'),
    stripDebug      = require('gulp-strip-debug'),
    uglify          = require('gulp-uglify'),
    autoprefix      = require('gulp-autoprefixer'),
    minifyCSS       = require('gulp-minify-css'),
    rename          = require('gulp-rename'),
    includejs       = require('gulp-include'),
    importcss       = require('gulp-cssimport'),
    sass            = require('gulp-ruby-sass');
 
var sources = {
    sass:              './app/assets/scss/*.scss',
    javascript:        './app/assets/js/app.js'
};

var targets = {
    css:    './public/css',
    js:     './public/js',
};

// JS hint task
gulp.task('jshint', function() {
    gulp.src('./app/assets/js/app.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

// JS concat, strip debugging and minify
gulp.task('scripts', function() {
    gulp.src(sources.javascript)
        .pipe(includejs())
        .pipe(gulp.dest(targets.js))
        .pipe(stripDebug())
        .pipe(uglify('compress'))
        .pipe(rename(function (path) { path.basename += '.min'; }))
        .pipe(gulp.dest(targets.js));
});

// compile CSS
gulp.task('sass', function() {

    gulp.src([
            './app/assets/scss/app.scss', 
            './app/assets/scss/app-admin.scss'
        ])
        .pipe(importcss())
        .pipe(sass({
            loadPath: [
                './bower_components/foundation/scss', 
                './bower_components'
            ]
        }))

        .pipe(autoprefix('last 2 versions'))
        .pipe(gulp.dest(targets.css))
        .pipe(minifyCSS())
        .pipe(rename(function (path) { path.basename += '.min'; }))
        .pipe(gulp.dest(targets.css));
});

gulp.task('watch', function () {
    gulp.watch('./app/assets/scss/**/*.scss', ['sass']);
    gulp.watch('./app/assets/js/*.js', ['scripts', 'jshint']);
});

gulp.task('default', ['sass', 'scripts', 'jshint', 'watch']);