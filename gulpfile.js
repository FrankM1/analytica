/**
 * Gulpfile.
 *
 * Gulp with WordPress.
 *
 * Implements:
 *      1. Live reloads browser with BrowserSync.
 *      2. CSS: Sass to CSS conversion, error catching, Autoprefixing, Sourcemaps,
 *         CSS minification, and Merge Media Queries.
 *      3. JS: Concatenates & uglifies Vendor and Custom JS files.
 *      4. Images: Minifies PNG, JPEG, GIF and SVG images.
 *      5. Watches files for changes in CSS or JS.
 *      6. Watches files for changes in PHP.
 *      7. Corrects the line endings.
 *      8. InjectCSS instead of browser page reload.
 *      9. Generates .pot file for i18n and l10n.
 *
 * @author Franklin Gitonga
 * @version 1.0.0
 */

var pkg = require('./package.json');

/**
 * Configuration.
 *
 * Project Configuration for gulp tasks.
 *
 * In paths you can add <<glob or array of globs>>. Edit the variables as per your project requirements.
 */
if(process.argv[2] === "--local") {
	process.env.DISABLE_NOTIFIER = true;
}

// Project related.
var project = "analytica"; // Project Name.
var projectURL = "analytica.local"; // Project URL. Could be something like localhost:8888.
var productURL = "./"; // Theme/Plugin URL. Leave it like it is, since our gulpfile.js lives in the root folder.

// Translation related.
var textDomain = "analytica"; // Your textdomain here.
var translationFile = textDomain + ".pot"; // Name of the transalation file.
var packageName = "analytica"; // Package name.
var bugReport = "https://qazana.net/contact/"; // Where can users report bugs.
var lastTranslator = "Franklin Gitonga <frank@radiumthemes.com>"; // Last translator Email ID.
var team = "Qazana <frank@radiumthemes.com>"; // Team's Email ID.
var translatePath = "./languages"; // Where to save the translation files.

// Style related.
var FrontendcssRC = "assets/frontend/sass/**/*.scss"; // Path to main .scss file.
var FrontendStyleDestination = "assets/frontend/css"; // Path to place the compiled CSS file.

var AdmincssRC = "assets/admin/sass/**/*.scss"; // Path to main .scss file.
var AdminStyleDestination = "assets/admin/css"; // Path to place the compiled CSS file.
// Defualt set to root folder.

var ExtenstioncssRC = "analytica/extensions/**/*.scss"; // Path to extensions .scss file.

// Images related.
var imagesSRC = "assets/frontend/images/raw/**/*.{png,jpg,gif,svg}"; // Source folder of images which should be optimized.
var imagesDestination = "assets/frontend/images/"; // Destination folder of optimized images. Must be different from the imagesSRC folder.

// Watch files paths.
var FrontendJSWatchFiles = [
	"assets/frontend/js/modules/**/*.js",
	"assets/extensions/**/*.js",
	"!assets/frontend/js/analytica-editor.js",
	"!assets/frontend/js/analytica-frontend.js"
]; // Path to all vendor JS files.
var AdminJSWatchFiles = "assets/admin/js/**/*.js"; // Path to all vendor JS files.

var build = "build/"; // Files that you want to package into a zip go here

var projectPHPWatchFiles = [
	'**/*.php',
	'!node_modules/**',
	'!bower_components/**',
	'!'+ build +'**',
	'!tests/**',
	'!.github/**',
	'!*~'
]; // Path to all PHP files.

var buildInclude = [
	// include common file types
	"**/*.php",
	"**/*.html",
	"**/*.css",
	"**/*.js",
	"**/*.svg",
	"**/*.ttf",
	"**/*.otf",
	"**/*.eot",
	"**/*.woff",
	"**/*.woff2",
	"**/*.jpg",
	"**/*.png",
	"**/*.gif",
	"**/*.txt",
	"**/*.mo",
    "**/*.pot",
    "**/*.json",
    "**/*.xml",
  
	"**/plugins/*.zip",

	// exclude files and folders
	"!node_modules/**/*",
	"!bower_components/**/*",
    "!style.css.map",
    "!gulpfile.js",
    "!Gruntfile.js",
	"!assets/frontend/js/modules/*",
	"!assets/frontend/sass/*"
];

// Browsers you care about for autoprefixing.
// Browserlist https        ://github.com/ai/browserslist
const AUTOPREFIXER_BROWSERS = [
	"last 2 version",
	"> 1%",
	"ie >= 9",
	"ie_mob >= 10",
	"ff >= 30",
	"chrome >= 34",
	"safari >= 7",
	"opera >= 23",
	"ios >= 7",
	"android >= 4",
	"bb >= 10"
];

// STOP Editing Project Variables.

/**
 * Load Plugins.
 *
 * Load gulp plugins and assing them semantic names.
 */
var gulp                  = require("gulp");                        // Gulp of-coursesourcemaps
var autoprefixer          = require("gulp-autoprefixer");           // Autoprefixing magic.
var banner                = require("gulp-banner");
var browserSync           = require("browser-sync").create();       // Reloads browser and injects CSS. Time-saving synchronised browser testing.
var browserify            = require("gulp-browserify");
var cache                 = require("gulp-cache");
var checktextdomain       = require("gulp-checktextdomain");
var cleanCSS              = require("gulp-clean-css");              // Minify CSS and merge combine matching media queries into one media query definition.
var concat                = require("gulp-concat");                 // Concatenates JS files
var filter                = require("gulp-filter");                 // Enables you to work on a subset of the original files by filtering them using globbing.
var git                   = require("gulp-git");
var gutil                 = require("gulp-util");
var ignore                = require("gulp-ignore");                 // Helps with ignoring files and directories in our run tasks
var imagemin              = require("gulp-imagemin");               // Minify PNG, JPEG, GIF and SVG images with imagemin.
var jshint                = require("gulp-jshint");
var lineec                = require("gulp-line-ending-corrector");  // Consistent Line Endings for non UNIX systems. Gulp Plugin for Line Ending Corrector (A utility that makes sure your files have consistent line endings)
var modernizr             = require("modernizr");
var notify                = require("gulp-notify");                 // Sends message notification to you
var rename                = require("gulp-rename");                 // Renames files E.g. style.css -> style.min.css
var replace               = require('gulp-replace');
var rimraf                = require("gulp-rimraf");                 // Helps with removing files and directories in our run tasks
var runSequence           = require("run-sequence");
var sass                  = require("gulp-sass");                   // Gulp pluign for Sass compilation.
var sort                  = require("gulp-sort");                   // Recommended to prevent unnecessary changes in pot-file.
var sourcemaps            = require("gulp-sourcemaps");             // Maps code in a compressed file (E.g. style.css) back to it’s original position in a source file (E.g. structure.scss, which was later combined with other css files to generate style.css)
var uglify                = require("gulp-uglify");                 // Minifies JS files
var wpPot                 = require("gulp-wp-pot");                 // For generating the .pot file.
var zip                   = require("gulp-zip");                    // Using to zip up our packaged theme into a tasty zip file that can be installed in WordPress!
var log                   = require('fancy-log');
var initReleaseIt         = require('gulp-release-it');
var line_ending_corrector = require('gulp-line-ending-corrector');
var standard = require('gulp-standard');

/**
 * Task: `browser-sync`.
 *
 * Live Reloads, CSS injections, Localhost tunneling.
 *
 * This task does the following:
 *    1. Sets the project URL
 *    2. Sets inject CSS
 *    3. You may define a custom port
 *    4. You may want to stop the browser from openning automatically
 */
gulp.task("browser-sync", function() {
	browserSync.init({
		// For more options
		// @link http://www.browsersync.io/docs/options/

		// Project URL.
		proxy: projectURL,

		// `true` Automatically open the browser with BrowserSync live server.
		// `false` Stop the browser from automatically opening.
		open: true,

		// Inject CSS changes.
		// Commnet it to reload browser for every CSS change.
		injectChanges: true

		// Use a specific port (instead of the one auto-detected by Browsersync).
		// port: 7000,
	});
});

/**
 * Task: `frontendcss`.
 *
 * Compiles Sass, Autoprefixes it and Minifies CSS.
 *
 * This task does the following:
 *    1. Gets the source scss file
 *    2. Compiles Sass to CSS
 *    3. Writes Sourcemaps for it
 *    4. Autoprefixes it and generates style.css
 *    5. Renames the CSS file with suffix .min.css
 *    6. Minifies the CSS file and generates style.min.css
 *    7. Injects CSS or reloads the browser via browserSync
 */
gulp.task("frontendcss", function() {
	gulp
		.src(FrontendcssRC)
		.pipe(sourcemaps.init())
		.pipe(
			sass({
				errLogToConsole: true,
				outputStyle: "expanded",
				//outputStyle: 'compressed',
				// outputStyle: 'nested',
				// outputStyle: 'expanded',
				precision: 10
			})
		)
		.on("error", gutil.log)
		.pipe(sourcemaps.write({ includeContent: false }))
		//.pipe(sourcemaps.init({ loadMaps: true }))
		//.pipe(autoprefixer(AUTOPREFIXER_BROWSERS))
		//.pipe(sourcemaps.write("./"))
		//.pipe(lineec()) // Consistent Line Endings for non UNIX systems.
		.pipe(gulp.dest(FrontendStyleDestination))
		.pipe(filter("**/*.css")) // Filtering stream to only css files
		.pipe(
			cleanCSS({
				level: {
					1: {
						all: false // sets all default values to 'false'
					},
					2: {
						all: false, // sets all default values to 'false'
						mergeMedia: true // combine only media queries
					}
				}
			})
		) // Merge Media Queries only for .min.css version.
		.pipe(browserSync.stream()) // Reloads style.css if that is enqueued.
		.pipe(rename({ suffix: ".min" }))
		.pipe(
			cleanCSS({
				level: 2 // full minification
			})
		)
		.pipe(lineec()) // Consistent Line Endings for non UNIX systems.
		.pipe(gulp.dest(FrontendStyleDestination))
		.pipe(filter("**/*.css")) // Filtering stream to only css files
		.pipe(browserSync.stream()); // Reloads style.min.css if that is enqueued.
});

gulp.task("extensionscss", function() {
	return(gulp
		.src(ExtenstioncssRC, { base: "." })
		.pipe(
			sass({
				includePaths: ["./assets/frontend/sass/"],
				errLogToConsole: true,
				outputStyle: "expanded",
				//outputStyle: 'compressed',
				// outputStyle: 'nested',
				// outputStyle: 'expanded',
				precision: 10
			})
		)
		.on("error", gutil.log)
		//.pipe(sourcemaps.write({ includeContent: false }))
		//.pipe(sourcemaps.init({ loadMaps: true }))
		.pipe(autoprefixer(AUTOPREFIXER_BROWSERS))
		//.pipe(sourcemaps.write("./"))
		.pipe(lineec()) // Consistent Line Endings for non UNIX systems.
		.pipe(gulp.dest("./"))
		.pipe(filter("**/*.css")) // Filtering stream to only css files
		.pipe(
			cleanCSS({
				level: {
					1: {
						all: false // sets all default values to 'false'
					},
					2: {
						all: false, // sets all default values to 'false'
						mergeMedia: true // combine only media queries
					}
				}
			})
		) // Merge Media Queries only for .min.css version.
		.pipe(browserSync.stream()) // Reloads style.css if that is enqueued.
		.pipe(rename({ suffix: ".min" }))
		.pipe(
			cleanCSS({
				level: 2 // full minification
			})
		)
		.pipe(lineec()) // Consistent Line Endings for non UNIX systems.
		.pipe(gulp.dest("./"))
		.pipe(filter("**/*.css")) // Filtering stream to only css files
		.pipe(browserSync.stream())); // Reloads style.min.css if that is enqueued.
});

/**
 * Task: `admincss`.
 *
 * Compiles Sass, Autoprefixes it and Minifies CSS.
 *
 * This task does the following:
 *    1. Gets the source scss file
 *    2. Compiles Sass to CSS
 *    3. Writes Sourcemaps for it
 *    4. Autoprefixes it and generates style.css
 *    5. Renames the CSS file with suffix .min.css
 *    6. Minifies the CSS file and generates style.min.css
 *    7. Injects CSS or reloads the browser via browserSync
 */
gulp.task("admincss", function() {
	gulp
		.src(AdmincssRC)
		//.pipe(sourcemaps.init())
		.pipe(
			sass({
				errLogToConsole: true,
				outputStyle: "expanded",
				// outputStyle: 'nested',
				// outputStyle: 'expanded',
				precision: 10
			})
		)
		.on("error", gutil.log)
		//.pipe(sourcemaps.write({ includeContent: false }))
		//.pipe(sourcemaps.init({ loadMaps: true }))
		.pipe(autoprefixer(AUTOPREFIXER_BROWSERS))
		//.pipe(sourcemaps.write("./"))
		.pipe(lineec()) // Consistent Line Endings for non UNIX systems.
		.pipe(gulp.dest(AdminStyleDestination))
		.pipe(filter("**/*.css")) // Filtering stream to only css files
		.pipe(
			cleanCSS({
				level: {
					1: {
						all: false // sets all default values to 'false'
					},
					2: {
						all: false, // sets all default values to 'false'
						mergeMedia: true // combine only media queries
					}
				}
			})
		) // Merge Media Queries only for .min.css version.
		.pipe(browserSync.stream()) // Reloads style.css if that is enqueued.
		.pipe(rename({ suffix: ".min" }))
		.pipe(
			cleanCSS({
				level: 2 // full minification
			})
		)
		.pipe(lineec()) // Consistent Line Endings for non UNIX systems.
		.pipe(gulp.dest(AdminStyleDestination))
		.pipe(filter("**/*.css")) // Filtering stream to only css files
		.pipe(browserSync.stream()); // Reloads style.min.css if that is enqueued.
});

 
gulp.task('standard', function () {
  return gulp.src(["assets/frontend/js/modules/**/*.js", "assets/admin/js/**/*.js"])
    .pipe(standard())
    .pipe(standard.reporter('default', {
      breakOnError: true,
      quiet: true
    }))
})

gulp.task("lintJs", function() {
	gulp
		.src(["assets/frontend/js/modules/**/*.js", "assets/admin/js/**/*.js"])
		.pipe(jshint())
		.pipe(jshint.reporter("default"));
});

/**
 * Task: `vendorFiles`.
 *
 * Concatenate and uglify vendor JS scripts.
 *
 * This task does the following:
 *     1. Gets the source folder for JS vendor files
 *     2. Concatenates all the files and generates vendors.js
 *     3. Renames the JS file with suffix .min.js
 *     4. Uglifes/Minifies the JS file and generates vendors.min.js
 */
gulp.task("vendorFiles", function() {
});

/**
 * Task: FrontendScriptsJs
 *
 * Look at src/js and concatenate those files, send them to assets/js where we then minimize the concatenated file.
 */
gulp.task("FrontendScriptsJs", function() {
    return gulp
    .src("assets/frontend/js/modules/**/*.js")
    .pipe(concat("main.js").on("error", gutil.log))
    .pipe(gulp.dest("assets/frontend/js"))
    .pipe(
        rename({
            basename: "main",
            suffix: ".min"
        })
    )
    .pipe(uglify().on("error", gutil.log))
    .pipe(gulp.dest("assets/frontend/js/"));
});

/**
 * Task: AdminScriptsJs
 *
 * Look at src/js and concatenate those files, send them to assets/js where we then minimize the concatenated file.
 */
gulp.task("AdminScriptsJs", function() {
	return gulp
		.src("assets/admin/js/modules/**/*.js")
		.pipe(concat("main.js").on("error", gutil.log))
		.pipe(gulp.dest("assets/admin/js"))
		.pipe(
			rename({
				basename: "main",
				suffix: ".min"
			})
		)
		.pipe(uglify().on("error", gutil.log))
		.pipe(gulp.dest("assets/admin/js/"));
});

/**
 * Task: `images`.
 *
 * Minifies PNG, JPEG, GIF and SVG images.
 *
 * This task does the following:
 *     1. Gets the source of images raw folder
 *     2. Minifies PNG, JPEG, GIF and SVG images
 *     3. Generates and saves the optimized images
 *
 * This task will run only once, if you want to run it
 * again, do it with the command `gulp images`.
 */
gulp.task("images", function() {
	gulp
		.src(imagesSRC)
		.pipe(
			imagemin({
				progressive: true,
				optimizationLevel: 3, // 0-7 low-high
				interlaced: true,
				svgoPlugins: [{ removeViewBox: false }]
			})
		)
		.pipe(gulp.dest(imagesDestination));
});

gulp.task('i18n', function() {
	return gulp
		.src(projectPHPWatchFiles)
		.pipe(checktextdomain({
			text_domain: textDomain, // Specify allowed domain(s)
			correct_domain: true,
			keywords: [ // List keyword specifications
				'__:1,2d',
				'_e:1,2d',
				'_x:1,2c,3d',
				'esc_html__:1,2d',
				'esc_html_e:1,2d',
				'esc_html_x:1,2c,3d',
				'esc_attr__:1,2d',
				'esc_attr_e:1,2d',
				'esc_attr_x:1,2c,3d',
				'_ex:1,2c,3d',
				'_n:1,2,4d',
				'_nx:1,2,4c,5d',
				'_n_noop:1,2,3d',
				'_nx_noop:1,2,3c,4d'
			],
		}));
});

/**
 * WP POT Translation File Generator.
 *
 * * This task does the following:
 *     1. Gets the source of all the PHP files
 *     2. Sort files in stream by path or any custom sort comparator
 *     3. Applies wpPot with the variable set at the top of this file
 *     4. Generate a .pot file of i18n that can be used for l10n to build .mo file
 */
gulp.task( 'translate', ['i18n'], function() {
	return gulp
		.src([
			'**/*.php',
			'!node_modules/**',
			'!bower_components/**',
            '!'+ build +'**',
			'!tests/**',
			'!.github/**',
			'!*~'
		])
		.pipe(sort())
		.pipe(
			wpPot({
				domain: textDomain,
				destFile: translationFile,
				package: packageName,
				bugReport: bugReport,
				lastTranslator: lastTranslator,
				team: team
			})
		)
		.pipe( gulp.dest( translatePath + '/' + translationFile ) );
});

/**
 * Clean gulp cache
 */
gulp.task("clear", ['clean'], function() {
	cache.clearAll();
});

gulp.task("usebanner", function() {

    var versionDate = new Date(); // javascript, just

    var comments = '/*\n' +
        ' * @name <%= pkg.name %>\n' +
		' * @version <%= pkg.version %>\n' +
		' * @description <%= pkg.description %>\n' +
        ' * @homepage <%= pkg.homepage %>\n' +
        ' * @author <%= pkg.author %>\n' +
        ' * @lastmodified '+ versionDate +'\n' +
        '*/\n';

	gulp.src(['assets/frontent/**/*.js'])
		.pipe(banner(comments, {
			pkg: pkg
		}))
		.pipe(gulp.dest('assets/frontent'));

	gulp.src(['assets/admin/*.js'])
		.pipe(banner(comments, {
			pkg: pkg
		}))
		.pipe(gulp.dest('assets/admin'));

});

gulp.task( "bump", function() {
    gulp.src(['style.css'])
		.pipe(replace(/Version: \d{1,1}\.\d{1,2}\.\d{1,2}/g, 'Version: ' + pkg.version))
        .pipe(gulp.dest('./'));
        
    return initReleaseIt(gulp);
});

gulp.task('commit', function () {
    return gulp.src('./')
        .pipe(git.add({ args: '--all', maxBuffer: Infinity }))
        .pipe(git.commit('Bump to ' + pkg.version, { maxBuffer: Infinity })) 
        .pipe(git.branch( pkg.version, '', function (err) { if (err) throw err; }));
});

/**
 * Clean tasks for zip
 *
 * Being a little overzealous, but we're cleaning out the build folder, codekit-cache directory and annoying DS_Store files and Also
 * clearing out unoptimized image files in zip as those will have been moved and optimized
 */
gulp.task("cleanup", function() {
	return gulp
		.src(build, {
			read: false
		}) // much faster
		.pipe(rimraf({ force: true }))
		.pipe(notify({ message: "Cleanup task complete", onLast: true }));
});

gulp.task("cleanupFinal", function() {
	return gulp
		.src(["./bower_components", "**/.sass-cache", "**/.DS_Store", build], {
			read: false
		}) // much faster
        .pipe(rimraf({ force: true }))
        .pipe(notify({ message: "cleanupFinal task complete", onLast: true }));
});

/**
 * Build task that moves essential theme files for production-ready sites
 *
 * bundleFiles copies all the files in buildInclude to build folder - check variable values at the top
 * buildImages copies all the images from img folder in assets while ignoring images inside raw folder if any
 */
gulp.task("bundleFiles", function() {
	return gulp
		.src(buildInclude)
		.pipe(gulp.dest(build))
		.pipe(notify({ message: 'Copy from "build" Completed! 💯', onLast: true }) );
});

/**
 * Zipping build directory for distribution
 *
 * Taking the build folder, which has been cleaned, containing optimized files and zipping it up to send out as an installable theme
 */
gulp.task("bundleZip", function() {
	return gulp.src( build + "/**/" )
		.pipe( zip( project + ".zip" ) )
        .pipe( gulp.dest("./") )
        .pipe(notify({ message: 'Zip file generation Completed! 💯', onLast: true }) );
});

gulp.task("css", ["frontendcss", "extensionscss", "admincss", "browser-sync"], function() {
    gulp.watch(FrontendcssRC, ["frontendcss"]); // Reload on SCSS file changes.
    gulp.watch(AdmincssRC, ["admincss"]); // Reload on SCSS file changes.
	gulp.watch(ExtenstioncssRC, ["extensionscss"]); // Reload on SCSS file changes.
});

gulp.task("js", ["FrontendScriptsJs", "AdminScriptsJs", "admincss", "browser-sync"], function() {
    gulp.watch(FrontendJSWatchFiles, ["FrontendScriptsJs"]); // Reload on vendorFiles file changes.
    gulp.watch(AdminJSWatchFiles, ["AdminScriptsJs"]); // Reload on vendorFiles file changes.
});

/**
 * Watch Tasks.
 *
 * Watches for file changes and runs specific tasks.
 */
gulp.task( "default", [ "vendorFiles", "FrontendScriptsJs", "AdminScriptsJs", "frontendcss", "admincss", "browser-sync"], function() {
    gulp.watch(projectPHPWatchFiles, browserSync.reload); // Reload on PHP file changes.
    gulp.watch(FrontendcssRC, ["frontendcss"]); // Reload on SCSS file changes.
    gulp.watch(ExtenstioncssRC, ["extensionscss"]); // Reload on SCSS file changes.
    gulp.watch(AdmincssRC, ["admincss"]); // Reload on SCSS file changes.
    gulp.watch(FrontendJSWatchFiles, ["FrontendScriptsJs"]); // Reload on vendorFiles file changes.
    gulp.watch(AdminJSWatchFiles, ["AdminScriptsJs"]); // Reload on vendorFiles file changes.
});

/**
 * Watch Tasks.
 *
 * Watches for file changes and runs specific tasks.
 */
gulp.task("buildFrontend", ["FrontendScriptsJs", "browser-sync"], function() {
	gulp.watch(projectPHPWatchFiles, browserSync.reload); // Reload on PHP file changes.
	gulp.watch(FrontendcssRC, ["frontendcss"]); // Reload on SCSS file changes.
	gulp.watch(ExtenstioncssRC, ["extensionscss"]); // Reload on SCSS file changes.
	gulp.watch(FrontendJSWatchFiles, ["FrontendScriptsJs"]); // Reload on vendorFiles file changes.
});

gulp.task("release", [ "cleanup", "translate", "images"], function(callback) {
	runSequence( 'usebanner', 'bundleFiles', 'bundleZip', 'FrontendScriptsJs', 'frontendcss', callback);
});

gulp.task("publish", function( callback ) {
    runSequence( 'commit', callback);
});

gulp.task("afterpublish", function( callback ) {
    runSequence( "bump",  callback);
});

gulp.task("push-to-remote", function( callback ) {
    // runSequence( "bump",  callback);
});
