// var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

var gulp = require('gulp'),
    minify = require('gulp-minify-css'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename');

var path = {
    'resources': {
        'css': './resources/assets/css',
        'js': './resources/assets/js'
    },
    'public': {
        'css': './public/assets/css',
        'js': './public/assets/js'
    },
    'js': './resources/assets/js/**/*.js',
    'css': './resources/assets/css/**/*.css',
    'views': './resources/views/**/*.php'
};

gulp.task('task_site_css', function () {
    return gulp.src(path.resources.css + '/site.css')
        .pipe(minify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(path.public.css))
});

gulp.task('task_back_css', function () {
    return gulp.src(path.resources.css + '/back.css')
        .pipe(minify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(path.public.css))
});

gulp.task('js_app', function () {
    return gulp.src(path.resources.js + '/site.js')
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(path.public.js))
});

gulp.task('js_admin', function () {
    return gulp.src(path.resources.js + '/admin.js')
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(path.public.js))
});

gulp.task('js_qcm', function () {
    return gulp.src(path.resources.js + '/qcm.js')
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(path.public.js))
});

gulp.task('js_eleve', function () {
    return gulp.src(path.resources.js + '/eleve.js')
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(path.public.js))
});


gulp.task('watch', function () {
    gulp.watch(path.css, ['task_site_css']);
    gulp.watch(path.css, ['task_back_css']);
    gulp.watch(path.js, ['js_app']);
    gulp.watch(path.js, ['js_admin']);
    gulp.watch(path.js, ['js_qcm']);
    gulp.watch(path.js, ['js_eleve']);
});

gulp.task('default', ['watch']);
