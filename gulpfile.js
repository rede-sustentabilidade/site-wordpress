var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
//    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    rename = require('gulp-rename'),
    imagemin = require('gulp-imagemin'),
		pngcrush = require('imagemin-pngcrush'),
    base_path = 'public/wp-content/themes/rede-sustentabilidade/';


gulp.task('styles', function() {
  return gulp.src(base_path + 'assets/styles/**/*.sass')
    .pipe(sass())
    //.pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1'))
    //.pipe(gulp.dest('css'))
    //.pipe(rename({suffix: '.min'}))
    .on('error', function (err) { console.log(err.message); })
    .pipe(minifycss())
    .pipe(gulp.dest(base_path));
});

//Task for sass using libsass through gulp-sass
// gulp.task('sass', function(){
//   gulp.src('sass/app.scss')
//     .pipe(sass({sourcemap: true, sourcemapPath: './sass'}))
//     .on('error', function (err) { console.log(err.message); })
//     .pipe(gulp.dest('build/css'));
// });

gulp.task('images', function () {
    return gulp.src(base_path + 'assets/images/**/*')
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngcrush()]
        }))
        .pipe(gulp.dest(base_path + 'assets/images/'));
});

gulp.task('watch', function() {

  // Watch the sass files
  gulp.watch(base_path + 'assets/styles/**/*.sass', ['styles']);

});

// Default task
gulp.task('default', ['watch']); //'plugins', 'scripts',

gulp.task('imagemin', ['images']); //'plugins', 'scripts',

gulp.task('build', ['styles']);

