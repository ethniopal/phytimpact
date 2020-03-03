import {config} from "./config.js";
import {src, dest, lastRun} from 'gulp';


// import rename       from "gulp-rename";

import sass         from "gulp-sass";
import postcss      from "gulp-postcss";
import autoprefixer from "autoprefixer";
import sourcemaps   from "gulp-sourcemaps";
import cssnano      from "cssnano";
import mmq          from 'gulp-merge-media-queries'; // Combine matching media queries into one media query definition.

import {browser}    from './server' //pour le live reload
import notify       from 'gulp-notify' //afficher notification


/**
 * Task: `styles`.
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
function styles() {

    return src([
        config.css.src + "/style.scss"
    ], {allowEmpty: true})

        .pipe(sourcemaps.init())

        .pipe(sass({outputStyle: "expanded"})).on("error", sass.logError)

        .pipe(mmq({log: true})) // Merge Media Queries only for .min.css version.

        .pipe(postcss([autoprefixer({grid:true}), cssnano()]))

        .pipe(sourcemaps.write('./css/sourcemaps'))
        .pipe(dest( config.css.dist))
        .pipe(browser.stream())
        .pipe(notify({message: 'TASK: "styles" Completed! 💯', onLast: true}));
}


/**
 * Task: `styles`.
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
function stylesVendor() {

    return src([
        config.css.src + "/**/*.scss",
        '!'+ config.css.src + "/style.scss",
        '!'+ config.css.src +'/_bootstrap/bootstrap.scss',
        '!'+ config.css.src +'/_bootstrap/bootstrap-grid.scss',
        '!'+ config.css.src +'/_bootstrap/bootstrap-reboot.scss'
    ], {allowEmpty: true, since: lastRun(stylesVendor)})

        .pipe(sourcemaps.init())

        .pipe(sass({outputStyle: "expanded"})).on("error", sass.logError)

        .pipe(mmq({log: true})) // Merge Media Queries only for .min.css version.

        .pipe(postcss([autoprefixer({grid:true}), cssnano()]))

        .pipe(sourcemaps.write('./sourcemaps'))
        .pipe(dest( config.css.dist + '/css/'))
        .pipe(browser.stream())
        .pipe(notify({message: 'TASK: "styles Vendors" Completed! 💯', onLast: true}));
}

export {
    styles, stylesVendor
}