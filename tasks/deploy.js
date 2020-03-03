import {ftp, connDB, basePath, srcDir, distDir} from "./config.js";
import {src}     from 'gulp';

import vinylFTP  from 'vinyl-ftp';
import mysqldump from 'mysqldump';
import notify    from 'gulp-notify'


/**
 * Mise en place sur le ftp
 * @returns {*}
 */
function uploadFTP () {

    const conn = vinylFTP.create({
        host: ftp.host,
        user: ftp.user,
        password: ftp.pass,
        parallel: 4,
        secure: true,
        secureOptions: {rejectUnauthorized: false}
    });

    const globs = [
        distDir + '/**/*',
        '!node_modules',
        '!node_modules/**'
    ];

    return src(globs, {base: basePath, buffer: false})
        .pipe(conn.dest(ftp.dir))
        .pipe(notify({message: 'TASK: FTP completed! 💯'}))

}


/**
 * Crée un backup de la base de donnée local
 */
function backupBD (){
// dump the result straight to a file

    mysqldump({
        connection: {
            host: connDB.host,
            user: connDB.user,
            password: connDB.pass,
            database: connDB.db,
        },
        dumpToFile: './dump.sql',
    });

}

export {
    uploadFTP, backupBD
}