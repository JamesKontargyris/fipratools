var gulp = require('gulp'),
    compass = require('gulp-compass'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    rename = require('gulp-rename'),
    imagemin = require('gulp-imagemin'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    del = require('del'),
    sassDir = 'app/assets/sass',
    cssDir = 'public/css',
    imgDir = 'public/img';

gulp.task('styles', function () {
    return gulp.src(sassDir + '/style.scss')
        .pipe(compass({
            style: 'nested',
            sass: sassDir,
            css: cssDir,
            image: imgDir,
            require: ['susy', 'breakpoint']
        }))
        //.pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(minifycss())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(cssDir))
        .pipe(notify({message: 'Styles task complete'}));
});

gulp.task('images', function () {
    return gulp.src(imgDir + '/**/*')
        .pipe(cache(imagemin({optimizationLevel: 3, progressive: true, interlaced: true})))
        .pipe(gulp.dest(imgDir))
        .pipe(notify({message: 'Images task complete'}));
});

gulp.task('watch', function () {
    gulp.watch(sassDir + '/**/*.scss', ['styles']);
});

gulp.task('default', function () {
    gulp.start('styles', 'watch');
});