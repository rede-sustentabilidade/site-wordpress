var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
//    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    rename = require('gulp-rename'),
    imagemin = require('gulp-imagemin'),
		pngcrush = require('imagemin-pngcrush'),
    base_path = 'public/',
    theme_path = base_path + 'wp-content/themes/rede-sustentabilidade/';


gulp.task('styles', function() {
  return gulp.src(theme_path + 'assets/styles/**/*.sass')
    .pipe(sass())
    //.pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1'))
    //.pipe(gulp.dest('css'))
    //.pipe(rename({suffix: '.min'}))
    .on('error', function (err) { console.log(err.message); })
    .pipe(minifycss())
    .pipe(gulp.dest(theme_path));
});

//Task for sass using libsass through gulp-sass
// gulp.task('sass', function(){
//   gulp.src('sass/app.scss')
//     .pipe(sass({sourcemap: true, sourcemapPath: './sass'}))
//     .on('error', function (err) { console.log(err.message); })
//     .pipe(gulp.dest('build/css'));
// });

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
  // Watch the sass files
  gulp.watch(theme_path + 'assets/styles/**/*.sass', ['styles']);

});

// Default task
gulp.task('default', ['watch']); //'plugins', 'scripts',

gulp.task('imagemin', ['images']); //'plugins', 'scripts',

gulp.task('build', ['styles']);
