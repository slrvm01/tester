const gulp      = require('gulp'),
    sass        = require('gulp-sass'),
    rename      = require('gulp-rename'),
    sourcemaps  = require('gulp-sourcemaps');

const cfg = {
    env: 'dev',
    path: {
        'scss': './resources/scss'
    }
};

gulp.task('scss', function () {
    return gulp.src('resources/scss/main.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(rename("styles.css"))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('public/assets/css'));
});

gulp.task('watch', function() {
    gulp.watch(cfg.path.scss + '/**/*/*.scss', ['build']);
});

gulp.task('build', ['scss']);

gulp.task('default', ['watch']);