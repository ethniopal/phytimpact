import {config as configData, basePath, distDir} from "./config";
import {watch}    from 'gulp';
import Browser from 'browser-sync';
import webpack from 'webpack';
import webpackDevMiddleware from 'webpack-dev-middleware';

import { config as webpackConfig } from './webpack';

import ngrok from 'ngrok';



const browser = Browser.create();
const bundler = webpack(webpackConfig);

function server(done) {

    //Configuration du serveur
    let configServer = {
        open: false,
        middleware: [
            webpackDevMiddleware(bundler, { /* options */ })
        ],
    };


    //Vérification s'il y a un proxy
    if(configData.proxy.length > 1){
        configServer.proxy = configData.proxy; //pour browser sync
        //Activation de ngrok
        (async function() {
            const url = await ngrok.connect(configData.proxy);
            console.log(" --------------------------------------");
            console.log("Lien ngrok:", url);
            console.log(" --------------------------------------");

        })();
    }
    else{ //Définition des fichiers qui seront modifé
        configServer.server = {
            baseDir: basePath + distDir + '/'
        };
        configServer.files = [
            configData.css.dist + '/**/*',
            configData.js.dist + '/**/*',
            configData.theme.dist + '/**/*.{htm, html, asp, aspx, php, xml}'
        ];
    }

    //initie le serveur
    browser.init(configServer);

    done();
}

function reload(done){
    browser.reload();
    done();
}

export {
    server, reload, browser
}