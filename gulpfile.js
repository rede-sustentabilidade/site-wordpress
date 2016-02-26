var gulp = require('gulp'),
    stylus = require('gulp-stylus'),
    minifycss = require('gulp-minify-css'),
    rename = require('gulp-rename'),
    imagemin = require('gulp-imagemin'),
		pngcrush = require('imagemin-pngcrush'),
    base_path = 'public/',
    theme_path = base_path + 'wp-content/themes/rede-sustentabilidade/';

gulp.task('styles', function () {
    gulp.src(theme_path + 'assets/styles/style.styl')
		    .pipe(stylus({
            linenos: true,
            compress: true
        }))
		    .pipe(gulp.dest(theme_path));
});

gulp.task('images', function () {
    return gulp.src(theme_path + 'assets/images/**/*')
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngcrush()]
        }))
        .pipe(gulp.dest(theme_path + 'assets/images/'));
});

gulp.task('copyPhp', function() {
    gulp.src(base_path + '**/*')
        .pipe(gulp.dest('./public.built'));
});

gulp.task('watch', function() {
  gulp.watch(base_path + '**/*', ['copyPhp']);
  gulp.watch(theme_path + 'assets/styles/**/*.styl', ['styles']);

});

gulp.task('default', ['watch']);
gulp.task('imagemin', ['images']);
gulp.task('build', ['styles']);
