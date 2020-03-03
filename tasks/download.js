import {config, basePath, distDir} from "./config.js";
import {src, dest}  from 'gulp';

import download     from 'gulp-download2';
import decompress   from 'gulp-decompress';
import del          from 'del';

import notify    from 'gulp-notify'


/**
 * Télécharge le git de base selon les données du fichiers de config
 * @param done
 * @returns {*}
 */
function downloadFiles(done) {

    let url = '';
    if(config.type === 'wp'){
        url = 'https://github.com/Automattic/_s/archive/master.zip';
    }
    else if(config.type === 'laravel'){
        url = 'https://github.com/Automattic/_s/archive/master.zip';
    }

    if(url.length > 1){
        return download(url)
            .pipe(dest(basePath + "downloads"))
            .pipe(notify({message: 'TASK: download completed! 💯'}))
            .pipe(decompress({strip: 1}))
            .pipe(dest(basePath + distDir))
            .pipe(notify({message: 'TASK: unzip completed! 💯'}))
            .pipe(deleteDownload())

    }
    else{
        done();
    }
}



/**
 * Delete downloads folder
 */
function deleteDownload() {
    return del([basePath + 'downloads/**']);
}

export {
    downloadFiles
}