var gulp           = require('gulp'),
    sass           = require('gulp-sass'),
    browserSync    = require('browser-sync'),
    cleanCSS       = require('gulp-clean-css'),
    autoprefixer   = require('gulp-autoprefixer');

var id_extension = 'd_social_share';

gulp.task('browser-sync', function() {
    browserSync({
        proxy: "localhost",
        notify: false
    });
});

gulp.task('sass', function() {
    return gulp.src('catalog/view/theme/default/stylesheet/'+id_extension+'/styles.scss')
        .pipe(autoprefixer(['last 15 versions']))
        .pipe(sass().on('error', sass.logError))
        .pipe(cleanCSS())
        .pipe(gulp.dest('catalog/view/theme/default/stylesheet/d_social_share'))
        .pipe(browserSync.reload({stream: true}));
});
// will compille styles in dark and light folders
gulp.task('d_admin_style', function() {
    return gulp.src('admin/view/stylesheet/d_admin_style/**/styles.scss')
        .pipe(autoprefixer(['last 15 versions']))
        .pipe(sass().on('error', sass.logError))
        .pipe(cleanCSS())
        .pipe(gulp.dest('admin/view/stylesheet/d_admin_style/'))
        .pipe(browserSync.reload({stream: true}));
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