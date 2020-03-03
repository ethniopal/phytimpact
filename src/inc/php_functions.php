<?php
/**
 * Retire les accents et les espaces de la chaine de caractère
 * @param $text
 * @return $text
 */
function slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

/**
 * Permet de transformer la première lettre en majuscule
 *
 * @param null $string
 * @return bool|mixed|string|null
 */
function ucfirstUtf8($s = null)
{
    header( "Content-Type: text/html; charset=utf8" );
    setlocale (LC_ALL, 'fr_FR.utf8');
    date_default_timezone_set('Europe/Paris');
    mb_internal_encoding("UTF-8");
    return mb_strtoupper( mb_substr( $s, 0, 1 )) . mb_substr( $s, 1 );
}


/**
 * Supprime les accents d'une chaine de caractère.
 *
 * @param $string
 * @return string
 */
function removeAccent ($string) {

    $search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u");
    $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u");
    $string = str_replace($search, $replace, $string);

    return $string;
}


/**
 * Check si url existe
 *
 * @param null $string
 * @return bool
 */
function url_exists($url) {
    if (!$fp = curl_init($url)) return false;
    return true;
}