import {basePath, srcDir, distDir, config} from "./config.js";
import {src, dest} from 'gulp';
import del from 'del';
import cache from 'gulp-cache';


/**
 * Permet d'effacer le fichier dist, si c'est l'initialisation du proejt supprime aussi le contenu du répertoire src
 * @returns {*}
 */
function cleanDist() {
    return del(config.theme.dist);
}


/**
 * Supprime les fichiers src qu'il y avait
 *
 * @returns {Promise<string[]> | never}
 */
function cleanInit() {
    return del(
            basePath + srcDir + '/*'
    );
}

/**
 * Clear la cache
 */
function clearCache(done) {
    cache.clearAll();
    done();
}

/**
 * Génère les répertoires à l'intérieurs de src
 * @returns {*}
 */
function generateSrcDirectory() {
    return src('*.*', {read: false})
        .pipe(dest( config.css.src ))
        .pipe(dest( config.img.src ))
        .pipe(dest( config.js.src ))
        .pipe(dest( config.js.src + '/modules' ))
        .pipe(dest( basePath + distDir ))
        .pipe(dest( basePath +'docs/' ))
        .pipe(dest( basePath +'templates/'))
}



export {
    generateSrcDirectory,
    cleanDist,
    cleanInit,
    clearCache
}