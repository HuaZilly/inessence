const { watch, src, dest } = require('gulp');
const autoprefixer = require('autoprefixer');
const uglify = require('gulp-uglify');
const babel = require('gulp-babel');
const rename = require('gulp-rename');
const postcss = require('gulp-postcss');
const cssnano = require('cssnano');
const sass = require('gulp-sass');

function minifyJS() {
  return src('wp-content/themes/matter/js/src/*.js')
    .pipe(babel({
        presets: ['@babel/env'],
        plugins: ['@babel/plugin-proposal-class-properties']
    }))
    .pipe(uglify())
    .pipe(rename({ extname: '.min.js' }))
    .pipe(dest('wp-content/themes/matter/js/'));
}

function minifyCSS() {
  return src('wp-content/themes/matter/sass/*.scss')
    .pipe(sass({outputStyle: 'expanded'}))
    .pipe(rename({ extname: '.min.css' }))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(dest('wp-content/themes/matter/css/'));
}

exports.default = function() {
    watch('wp-content/themes/matter/js/src/*.js', minifyJS);
    watch('wp-content/themes/matter/sass/**/*.scss', minifyCSS);
}