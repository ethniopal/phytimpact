import {config} from "./config.js";
import {src, dest, lastRun} from 'gulp';
import notify    from 'gulp-notify' //afficher notification



function copy() {
    return src([
            config.theme.src +'/**/*',
            config.theme.src +'/img/favicon/*',
            '!'  + config.theme.src + '/plugins/**/*',
            '!'  + config.theme.src + '/mu-plugins/**/*',
            '!' + config.theme.src + '/{js,js/**,css,css/**,scss,scss/**,img,img/**}'], //Fichier et répertoire à ne pas copier
        {allowEmpty: true, since: lastRun(copy) })

        .pipe(dest(config.theme.dist))
        .pipe(notify({message: 'TASK: Copy completed! 💯', onLast: true}));

}

function copyPlugins(done) {
    if(config.type=='wp') {
        return src(
            config.plugins.src + '/**/*', {allowEmpty: true, since: lastRun(copyPlugins)})
            .pipe(dest(config.plugins.dist))

            .pipe(src(
                config.muplugins.src + '/**/*', {allowEmpty: true, since: lastRun(copyPlugins)})
            )
            .pipe(dest(config.muplugins.dist))
            .pipe(notify({message: 'TASK: Copy completed! 💯', onLast: true}));
    }
    done();
}



export {
    copy, copyPlugins
}