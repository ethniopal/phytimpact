import {config, basePath, distDir} from "./config.js";

import fs from "fs";
import mysql from 'mysql';

const {db, host, port, user, pass, files} = config.connDB;

let connection;

/**
 * Éxécution des scripts
 */
export default function sql(done) {

    if(db.length > 0 || files.length > 0 ){
        connectDB();
        createDB();
    }
    done();
}

/**
 * Connexion à la base de données
 */
function connectDB() {

    connection = mysql.createConnection({
        host: host,
        port: port,
        user: user,
        password: pass,
        multipleStatements: true
    });

    connection.on('error', () => {
        endConnection();
    })
}


/**
 * Création de la base de donnée initial
 * @param done
 */
function createDB() {

    //se connecte
    connection.connect(function (err) {
        if (err)  throw err


        if (db) {
            //Crée la base de données si elle n'existe pas
            connection.query(`CREATE DATABASE IF NOT EXISTS ${db}`, function (err, result) {
                if (err) throw err;
                console.log(`Database ${db} created`);

                //Force l'utilisation de celle-ci
                connection.query(`USE ${db}`, function (err, result) {
                    if (err) throw err;
                    console.log(`USE : ${db}`);

                    runSqlFile(); // exécute la liste des fichiers inscrit dans le fichier config

                });

            });

        } else {
            runSqlFile(); // exécute la liste des fichiers inscrit dans le fichier config
        }

    });

}


/**
 * exécute les fichiers sql demandés
 */
function runSqlFile() {
    //execute les fichier sql s'il y en a
    if (files.length > 0) {

        //vérifie tous les fichiers voulus
        files.forEach((file, index) => {

            try {

                file = file.replace(/^(.\/|..\/)/, file); //s'assure de controlé un minimum le path

                const fileContent = fs.readFileSync(`./${file}`, "utf8");

                connection.query(fileContent, function (err, result) {
                    if (err) throw err;
                    console.log(`File : ${file} executed`);

                    if ((files.length - 1) === index) {
                        endConnection();
                    }
                });

            } catch {
                console.log(`Error in file : ${file}`)
                if ((files.length - 1) === index) {
                    endConnection();
                }
            }
        });

    }
}


/**
 * Fermeture de la connexion
 */
function endConnection() {
    connection.end();
    connection.destroy();

}