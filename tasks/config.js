const basePath = './'; //là ou se situe le fichier gulp
const srcDir = 'src';
const distDir = 'www';

const config = {
    name: 'phytimpact', //Nom du thème/projet (sans espace ni de caractère accentué)
    proxy: 'http://dev.phytimpact', //Url local, laisser vide si désire l'utiliser sans sous-domaine ex.: http://dev.test/
    type: 'wp',  //Valeur possible : wp, laravel, html, react
    server: 'wamp', //création automatique des virtuals hosts, selon le proxy et le chemin public, il faudra indiqué le chemin d'installation plus bas, laisser vide si pas sur wamp
    connDB: {
        db: '', //*************** à modifier **********************
        host: 'localhost',
        port: 3306,
        user: 'root',
        pass: '',
        files: [ //fichier(s) sql a partir de la racine à exécuter dans la base de données, si aucun fichier laissé vide

        ]
    },
    css: {
        src: basePath + srcDir + '/scss',
        dist: basePath + distDir,
    },
    img: {
        src: basePath + srcDir + '/img',
        dist: basePath + distDir + '/img',
        ext: 'png,jpg,jpeg,gif,svg,svgz,webp',
        quality: 60,
    },
    js: {
        src: basePath + srcDir + '/js',
        dist: basePath + distDir + '/js',
        entry:{
            main:['./main.js'],
            // autre:['./main.js'], //Si on veut un autre fichier bundle JS
        },
        filename:'[name].bundle.js',
    },
    theme: {
        src: basePath + srcDir,
        dist: basePath + distDir,
    },
    apache: { //afin que les vhost et execution de wampserver se fasse automatiquement
        exe: 'I:\\Job\\wamp64\\wampmanager.exe',
        dir: 'I:\\Job\\wamp64\\bin\\apache\\apache2.4.39'
    }
};



const ftp = {
    host: '184.107.112.54',
    user: '',
    pass: '',
    dir: '/public_html'
};

const themeWP = basePath + distDir + '/wp-content/themes/' + config.name; //à modifier si le chemin wordpress change
const uploadWP = basePath + distDir + '/wp-content/uploads'; //à modifier si le chemin wordpress change

switch (config.type) {
    case 'wp':
        config.css.dist = themeWP;
        config.js.dist = themeWP + '/js';
        config.img.dist = themeWP + '/img';
        config.theme.dist = themeWP;

        config.plugins = {
            src: themeWP + '/plugins',
            dist: basePath + distDir + '/wp-content/plugins'
        };

        config.muplugins = {
            src: themeWP + '/mu-plugins',
            dist: basePath + distDir + '/wp-content/mu-plugins'
        };

        break;
    case 'laravel':
        //src
        config.css.src = basePath + 'resources/assets/scss';
        config.js.src = basePath + 'resources/assets/js';
        config.img.src = basePath + 'resources/assets/img';

        //dist
        config.css.dist = basePath + 'public/css';
        config.js.dist = basePath + 'public/js';
        config.img.dist = basePath + 'public/img';
        config.theme.dist = basePath + 'public';
        break;
    case 'react':
        break;
    case 'html':
        break;

    default:
        break;
}

export { basePath, srcDir, distDir, config, themeWP,  uploadWP, ftp};