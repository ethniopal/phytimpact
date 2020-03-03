import {series, parallel, watch} from 'gulp';
import {config as configData, config} from "./config";

import { scripts } from './webpack';
import { server , reload }  from './server';
import { cleanInit, cleanDist, generateSrcDirectory , clearCache }  from './clean';
import { optimiseImages, optimiseImagesWp , resizeImage }  from './images';
import { styles, stylesVendor }  from './css';
import { copy as copyFiles }  from './copy';
import { downloadFiles }  from './download';
import { uploadFTP, backupBD }  from './deploy';
import { wamp }  from './wamp';

import createDatabase from './bd';



/**
 * Permet d'observer les fichiers
 */
function watchFiles () {
    const {css, js, theme, img, plugins, muplugins, type} = config;

    watch(css.src + '/**/*.scss', parallel(styles, stylesVendor));
    watch(theme.src + '/**/*').on('change', series(copyFiles, reload));
    watch(img.src + '/**/*').on('change', series(optimiseImages, reload));
    watch(js.src + '/**/*.js').on('change', series(scripts, reload));

    // watch('config.**/*', clearCache);
    //pour wordpressqq
    // if(type=='wp'){
    //     watch([
    //         plugins.src + '/**/*',
    //         muplugins.src + '/**/*']).on('change', series(copyPlugins));
    // }
}

// Les différentes tâches du gulp
export const init  = series(cleanDist, generateSrcDirectory, wamp, createDatabase/*, downloadFiles  */);
export const dev   = series(parallel(styles, stylesVendor, copyFiles, scripts), parallel(watchFiles, server));
export const build = series( cleanDist, parallel(styles, stylesVendor, copyFiles, optimiseImages, optimiseImagesWp), scripts, uploadFTP, backupBD );

//Les tâches individuel
export const clean   = series(cleanDist);
export const cleanSrc   = series(cleanInit);
export const resize  = series(resizeImage);
export const js = series(scripts);
export const css  = series(styles);
export const copy  = series(copyFiles);
export const sql  = series(createDatabase);
export const vhost  = series(wamp);


export default dev;