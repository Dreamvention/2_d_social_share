var gulp           = require('gulp'),
    sass           = require('gulp-sass'),
    browserSync    = require('browser-sync'),
    cleanCSS       = require('gulp-clean-css'),
    autoprefixer   = require('gulp-autoprefixer');

var id_extension = 'd_social_login';
gulp.task('browser-sync', function() {
    browserSync({
        proxy: "localhost",
        notify: false
    });
});

gulp.task('sass', function() {
    return gulp.src('catalog/view/theme/default/stylesheet/d_social_share/styles.scss')
        .pipe(autoprefixer(['last 15 versions']))
        .pipe(sass().on('error', sass.logError))
        .pipe(cleanCSS())
        .pipe(gulp.dest('catalog/view/theme/default/stylesheet/d_social_share'))
        .pipe(browserSync.reload({stream: true}))
});

gulp.task('watch', ['sass', 'browser-sync'], function() {
    gulp.watch('catalog/view/theme/default/stylesheet/**/*.scss', ['sass']);
    gulp.watch('catalog/controller/extension/module/d_social_share.php', browserSync.reload);
    gulp.watch('system/config/d_social_share.php', browserSync.reload);
    gulp.watch('catalog/view/theme/default/template/**/*.twig', browserSync.reload);
    gulp.watch('catalog/view/theme/default/js/**/*.js', browserSync.reload);
    gulp.watch('catalog/view/theme/default/libs/**/*', browserSync.reload);
});

gulp.task('default', ['watch']);