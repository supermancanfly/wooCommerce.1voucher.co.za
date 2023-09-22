'use strict';
var gulp = require('gulp');
var sass = require('gulp-sass');
var plumber = require('gulp-plumber');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var sourcemaps = require('gulp-sourcemaps');
var cleanCSS = require('gulp-clean-css');

gulp.task('sass', function () {
  return gulp.src('./dev/scss/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(cleanCSS())
    .pipe(sourcemaps.write('./maps'))
    .pipe(gulp.dest('./dist/css/'));
});

gulp.task('scripts', function() {
  return gulp.src([
      './dev/js/jquery-3.2.1.min.js',
      './dev/js/jquery.waypoints.js',
      './node_modules/simple-parallax-js/dist/simpleParallax.js',
      './node_modules/slick-carousel/slick/slick.js',
      './dev/js/slick-filter.js',
      './dev/js/jquery.selectric.js',
      './dev/js/jquery.magnific-popup.min.js',
      //'./dev/js/jquery.donetyping.js',
      './dev/js/onload.js'
    ])
    .pipe(plumber())
    .pipe(concat('scripts.js'))
    .pipe(uglify())
    .pipe(gulp.dest('./dist/js/'));
});

// dont roll this back again, update your gulp
gulp.task('watch', function() {
  gulp.watch('./dev/js/*.js', gulp.series('scripts'));
  gulp.watch('./dev/scss/**/*.scss', gulp.series('sass'));
});

gulp.task('default', gulp.series('sass', 'scripts', 'watch'));
