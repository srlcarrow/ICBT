'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');
var pump = require('pump')

gulp.task('sass', function () {
    return gulp.src('./sass/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./css'));
});

// gulp.task('sass:watch', function () {
//     gulp.watch('./sass/**/*.sass', ['sass']);
// });

gulp.task('js', function (cb) {
    pump([
            gulp.src('./js/custom/*.js'),
            uglify(),
            gulp.dest('./dist/js/custom')
        ],
        cb
    );
});

gulp.task('default', function () {
    gulp.watch('./sass/**/*.scss', ['sass']);
    //gulp.watch('./js/custom/*.js', ['js']);
});