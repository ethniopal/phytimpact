import {config, uploadWP} from "./config.js";
import {src, dest, lastRun} from 'gulp';

import imagemin         from 'gulp-imagemin'; // Minify PNG, JPEG, GIF and SVG images with imagemin.
import imageminPngquant from 'imagemin-pngquant';
import imageminZopfli   from 'imagemin-zopfli';
import imageminMozjpeg  from 'imagemin-mozjpeg'; //need to run 'brew install libpng'
import imageminGiflossy from 'imagemin-giflossy';

import resizer          from 'gulp-images-resizer';

import cache            from 'gulp-cache';
import notify           from 'gulp-notify' //afficher notification


const {type, img} = config;
const search = '/**/*.{' + img.ext + ',' + img.ext.toUpperCase() + '}';

/**
 * Optimisation des images wordpress
 * @param done
 * @returns {*}
 */
function optimiseImagesWp (done){

    if( type ==='wp' ){

        const srcImg = uploadWP + search;
        const distImg = uploadWP;

        return src(srcImg, {since: lastRun(optimiseImagesWp)})
            .pipe(cache(imagemin([
                //png
                imageminPngquant({
                    speed: 1,
                    quality: [0.95, 1] //lossy settings
                }),
                imagemin.optipng({optimizationLevel: 5}),

                imageminZopfli({
                    more: true
                    // iterations: 50 // very slow but more effective
                }),
                //gif very light lossy, use only one of gifsicle or Giflossy
                imageminGiflossy({
                    optimizationLevel: 3,
                    optimize: 3, //keep-empty: Preserve empty transparent frames
                    lossy: 2
                }),
                //svg
                imagemin.svgo({
                    plugins: [{removeViewBox: false},
                        {collapseGroups: true}]
                }),
                //jpg lossless
                imagemin.jpegtran({
                    progressive: true
                }),
                //jpg very light lossy, use vs jpegtran
                imageminMozjpeg({
                    quality: 70
                })
            ])))
            .pipe(dest(distImg))
            .pipe(notify({message: 'TASK: "images WP optimized" Completed! 💯', onLast: true}));
    }

    done();

}

/**
 * Optimisation du répertoire d'image défini dans le fichier config
 * @returns {*}
 */
function optimiseImages (){

    const srcImg = img.src + search;
    const distImg = img.dist;

    return src(srcImg, {since: lastRun(optimiseImages)})
        .pipe(cache(imagemin([
            //png
            imageminPngquant({
                speed: 1,
                quality: [0.95, 1] //lossy settings
            }),
            imagemin.optipng({optimizationLevel: 5}),

            imageminZopfli({
                more: true
                // iterations: 50 // very slow but more effective
            }),
            //gif very light lossy, use only one of gifsicle or Giflossy
            imageminGiflossy({
                optimizationLevel: 3,
                optimize: 3, //keep-empty: Preserve empty transparent frames
                lossy: 2
            }),
            //svg
            imagemin.svgo({
                plugins: [{removeViewBox: false},
                    {collapseGroups: true}]
            }),
            //jpg lossless
            imagemin.jpegtran({
                progressive: true
            }),
            //jpg very light lossy, use vs jpegtran
            imageminMozjpeg({
                quality: 70
            })
        ])))
        .pipe(dest(distImg))
        .pipe(notify({message: 'TASK: "images optimized" Completed! 💯', onLast: true}));
}


/**
 * Permet de redimentionner les images Selon se qui est inscrit dans le tableau project.img.transform
 * @returns {*}
 */
function resizeImage() {
    const srcImg = `${img.src}/resize${search}`;

    return src(srcImg, {since: lastRun(resizeImage)})
        .pipe(resizer({
            format: '*',
            width: 900,
            height: 900,
            quality:70,
            Crop:false
        }))
        // .pipe(rename(function (path) {
        //     path.basename = path.basename.substring(2);
        //     path.basename = path.basename.slice(0, path.basename.indexOf('-'))
        // }))
        .pipe(dest(img.dist + '/resize'));
};
export {
    optimiseImages, optimiseImagesWp, resizeImage
}