//Place this gulp project inside of the folder for your WordPress Theme

//Initialize modules
const {src, dest, watch, series, parallel} = require('gulp');
const autoprefixer = require('autoprefixer');

//reloads browser on file change
const browserSync = require('browser-sync').create();

//Optimize PNG, JPEG, GIF, SVG images with gulp task.
const imagemin = require('gulp-imagemin');
const concat = require('gulp-concat');

//passes through only those source files that are newer
const newer = require('gulp-newer');

//PostCSS gulp plugin to pipe CSS through several plugins, but parse CSS only once.
const postcss = require('gulp-postcss');
const sass = require('gulp-sass');
const cssnano = require('cssnano');
const sourcemaps = require('gulp-sourcemaps');
const uglify = require('gulp-uglify');
//Sourcemap support for gulpjs.
const jshint = require('gulp-jshint');


//File path variables
const root = '../';
console.log('Root Folder = ' + root);
const files = {
	scss: root + 'sass/',
	js: root + 'js/',
	img: root + 'images/'
};

//Sass Task - compile sass

function scssTask() {
	return src(files.scss + '**/*')
			.pipe(sourcemaps.init()) // initialize sourcemaps first
			.pipe(sass({outputStyle: 'expanded', indentType: 'tab', indentWidth: '1'}).on('error', sass.logError)) // compile SCSS to CSS
			.pipe(postcss([ autoprefixer('last 2 versions', '> 1%') ])) // PostCSS plugins
			.pipe(sourcemaps.write(root + 'maps')) // write sourcemaps file in special maps directory
			.pipe(dest(root)) // put final CSS in dist folder
			.pipe(browserSync.stream());
}


//JS Task - concatonate and minify JS files
function jsTask() {
	return src(files.js + '*.js')
			.pipe(jshint())
			.pipe(jshint.reporter('default'))
			.pipe(browserSync.stream());
}

//initialize Browser-Sync.  Passing this before the SASS and JS tasks so they can stream to the browserSync arguments
browserSync.init({
	open: 'external',
	proxy: 'localhost/wordpress',
	port: 8080
});

//Imagemin
function imageminTask() {
	return src(files.img + 'RAW/*.{png,jpg,jpeg,gif,svg}')
			.pipe(imagemin())
			.pipe(dest(files.img));
}



//Watch task - detects changes in the project, and runs these tasks again
function watchTask() {
	watch([files.scss + '**/*'], series(scssTask));
	watch([files.js], series(jsTask));
	watch([files.img + 'RAW/*.{png,jpg,jpeg,gif,svg}'], series(imageminTask));
	//watch([root], parallel(browserSync.stream()));
}


//Default task - Runs everything when you type gulp
exports.default = series(
		parallel(scssTask, jsTask),
		watchTask
		);