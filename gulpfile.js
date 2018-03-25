var gulp = require('gulp'),
    sass = require('gulp-sass'),
    browserSync = require('browser-sync'),
    cleanCSS = require('gulp-clean-css'),
    riot = require('gulp-riot'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    autoprefixer = require('gulp-autoprefixer');

var id_extension = 'd_social_share';

gulp.task('browser-sync', function () {
    browserSync({
        proxy: "localhost",
        notify: false
    });
});
gulp.task('riot', function () {
    return gulp.src('admin/view/template/extension/' + id_extension + '/**/*.tag')
        .pipe(riot({compact: true}))
        .pipe(concat('compiled.js'))
        .pipe(gulp.dest('admin/view/template/extension/' + id_extension + '/compiled/'))
        .pipe(browserSync.reload({stream: true}));
});
gulp.task('scripts', function () {
    return gulp.src([
//        'admin/view/javascript/'+id_extension+'/library/alertify/alertify.min.js',
        'admin/view/javascript/' + id_extension + '/library/immutable/immutable.min.js',
        'admin/view/javascript/'+id_extension+'/library/serializejson/jquery.serializejson.min.js',

        'admin/view/javascript/d_riot/riot.min.js',// есть новее
        // 'admin/view/javascript/d_riot/'+id_extension+'/library/riot/route/route_plus_tag.min.js',
        'admin/view/javascript/' + id_extension + '/core.js',
        // 'admin/view/javascript/'+id_extension+'/mixin/*.js',
        // 'admin/view/javascript/'+id_extension+'/section/*.js'
    ])
        .pipe(concat('core_and_libs.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('admin/view/javascript/' + id_extension + '/compiled/'))
});
gulp.task('sass', function () {
    return gulp.src('catalog/view/theme/default/stylesheet/' + id_extension + '/styles.scss')
    // return gulp.src('admin/view/stylesheet/' + id_extension + '/styles.scss'
    // )
        .pipe(autoprefixer(['last 15 versions']))
        .pipe(sass().on('error', sass.logError))
        .pipe(cleanCSS())
        .pipe(gulp.dest('catalog/view/theme/default/stylesheet/d_social_share'))
        // .pipe(gulp.dest('admin/view/stylesheet/' + id_extension))
        .pipe(browserSync.reload({stream: true}));
});
// will compille styles in dark and light folders
gulp.task('d_admin_style', function () {
    return gulp.src('admin/view/stylesheet/d_admin_style/**/styles.scss')
        .pipe(autoprefixer(['last 15 versions']))
        .pipe(sass().on('error', sass.logError))
        .pipe(cleanCSS())
        .pipe(gulp.dest('admin/view/stylesheet/d_admin_style/'))
        .pipe(browserSync.reload({stream: true}));
});

gulp.task('watch', ['riot', 'scripts', 'browser-sync'], function () {
    //wathc admin
    gulp.watch('admin/view/stylesheet/' + id_extension + '/*.scss', ['sass']);
    gulp.watch('admin/view/javascript/' + id_extension + '/**/*.js', ['scripts']);
    gulp.watch('admin/view/template/extension/' + id_extension + '/**/*.tag', ['riot']);
    //watch from
    gulp.watch('catalog/view/theme/default/stylesheet/**/*.scss', ['sass']);
    gulp.watch('catalog/controller/extension/module/d_social_share.php', browserSync.reload);
    gulp.watch('system/config/d_social_share.php', browserSync.reload);
    gulp.watch('catalog/view/theme/default/template/**/*.twig', browserSync.reload);
    gulp.watch('catalog/view/theme/default/js/**/*.js', browserSync.reload);
    gulp.watch('catalog/view/theme/default/libs/**/*', browserSync.reload);
});


gulp.task('default', ['watch']);