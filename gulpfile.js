'use strict';

const { series } = require( 'gulp' );

let gulp = require('gulp');
let sass = require('gulp-sass');
// let watch = require('gulp-watch');
let babel = require("gulp-babel");
let webpack = require('webpack-stream');
let rename = require('gulp-rename');
let uglify = require('gulp-uglify');
let cleanCSS = require('gulp-clean-css');
let sourcemaps = require('gulp-sourcemaps');

sass.compiler = require('node-sass');

function compilePublicSass(cb) {
    return gulp.src('./assets/css/public/src/sass/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./assets/css/public/src'));
}

function complieAdminSass(cb) {
    return gulp.src('./assets/css/admin/src/sass/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./assets/css/admin/src'));
}

function minifyPublicCSS(cb) {
    return gulp.src('./assets/css/public/src/styles.css')
        .pipe(sourcemaps.init())
        .pipe(cleanCSS())
        .pipe(sourcemaps.write())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./assets/css/public/dist'));
}

function minifyAdminCSS(cb) {
    return gulp.src('./assets/css/admin/src/styles.css')
        .pipe(sourcemaps.init())
        .pipe(cleanCSS())
        .pipe(sourcemaps.write())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./assets/css/admin/dist'));
}

function minifyPublicJS(cb) {
    return gulp.src('./assets/js/public/src/scripts.js')
        .pipe(webpack({output: {filename: 'scripts.js'} }))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./assets/js/public/dist'));
}

function minifyAdminJS(cb) {
    return gulp.src('./assets/js/admin/src/scripts.js')
        .pipe(uglify())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./assets/js/admin/dist'));
}

function watchFiles() {
    gulp.watch(
        ['./assets/css/public/src/sass/*.scss'],
        compilePublicSass
    );
}

const watch = gulp.parallel(watchFiles);


exports.default = series(compilePublicSass, minifyPublicCSS, minifyPublicJS, complieAdminSass, minifyAdminCSS, minifyAdminJS);
// exports.watch = gulp.watch(
//     ['./assets/css/public/src/sass/*.scss'],
//     compilePublicSass
// );
exports.watch = watch;