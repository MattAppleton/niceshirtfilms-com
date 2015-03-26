var gulp = require('gulp');
var watch = require('gulp-watch');
var rename = require('gulp-rename');
var notify = require('gulp-notify');
var util = require('gulp-util');

var jshint = require('gulp-jshint');
var uglify = require('gulp-uglify');

var stylus = require('gulp-stylus');
var autoprefixer = require('gulp-autoprefixer');
var minifycss = require('gulp-minify-css');

function errorNotify(error){
  notify.onError("Error: <%= error.message %>")
  util.log(util.colors.red('Error'), error.message);
}

gulp.task('js', function() {
  gulp.src([
    'js/main.js',
    'js/library.js'
  ])
  .pipe(jshint({
    browser: true,
    jquery: true,
    devel: true,
    unused: true,
    indent: 2,
  }))
  .pipe(jshint.reporter('jshint-stylish'))
  .on('error', errorNotify)
  .pipe(uglify())
  .on('error', errorNotify)
  .pipe(rename({suffix: '.min'}))
  .pipe(gulp.dest('js'))
  .pipe(notify({ message: 'Js task complete' }));
});

gulp.task('style', function() {
  return gulp.src('css/site.styl')
    .pipe(stylus())
    .on('error', errorNotify)
    .pipe(autoprefixer())
    .on('error', errorNotify)
    .pipe(gulp.dest('css'))
    .pipe(rename({suffix: '.min'}))
    .pipe(minifycss())
    .on('error', errorNotify)
    .pipe(gulp.dest('css'))
    .pipe(notify({ message: 'Style task complete' }));
});

gulp.task('watch', function() {
  gulp.watch(['js/main.js'], ['js']);
  gulp.watch(['css/site.styl'], ['style']);
});

gulp.task('default', ['watch']);
