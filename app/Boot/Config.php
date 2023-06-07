<?php


/**
 *   CONNECTION DB
 */
const CONF_DB_HOST = 'localhost';
const CONF_DB_NAME = 'TechNews';
const CONF_DB_USER = 'root';
const CONF_DB_PASSWORD = '';




/**
 *   PROJECT URLs
 */

const CONF_URL_BASE = 'http://localhost/TechNews.com';
const CONF_URL_TEST = 'http://localhost/TechNews';
const CONF_URL_SENAC = 'http://localhost/repos-TechNews/';

const CONF_PATH_VIEWS = CONF_URL_BASE . '/views';


/**
 * SITE
 */

const CONF_SITE_DOMAIN_TEST = 'localhost';


/**
 * PASSWORD
 */

const CONF_PASSWD_MIN_LEN = 6;
const CONF_PASSWD_MAX_LEN = 40;
const CONF_PASSWD_ALGO = PASSWORD_DEFAULT;
const CONF_PASSWD_OPTIONS = ['cost' => 10];


/**
 * UPLOAD
 */
const CONF_UPLOAD_DIR = '/storage/uploads';
const CONF_UPLOAD_IMAGE_DIR = 'images';
const CONF_UPLOAD_PHOTO_DIR = CONF_UPLOAD_IMAGE_DIR . '/photos';
const CONF_UPLOAD_BANNER_DIR = CONF_UPLOAD_IMAGE_DIR . '/banners';
const CONF_UPLOAD_COVER_DIR = CONF_UPLOAD_IMAGE_DIR . '/covers';

/**
 * IMAGES
 */
const CONF_IMAGE_CACHE = CONF_UPLOAD_DIR . '/' . CONF_UPLOAD_IMAGE_DIR . '/cache';
const CONF_IMAGE_SIZE = 'sei la';
const CONF_IMAGE_QUALITY = ['jpg' => 72, 'png' => 5];

const CONF_IMAGE_PHOTO_SIZE = 700;
const CONF_IMAGE_BANNER_SIZE = 1250;
const CONF_IMAGE_COVER_SIZE = 850;


/**
 *   MAIL
 */
// const CONF_MAIL_HOST = smtp.gmail.com;
// const CONF_MAIL_PORT = 587;
// const CONF_MAIL_USER = fabriciolves.dev@gmail.com;
// const CONF_MAIL_PASS = Escooby098.;
// const CONF_MAIL_SENDER = [
//     name => Fabrício =
//     address => fabricioalves.dev@gmail.com
// ];

const CONF_MAIL_HOST = 'smtp.gmail.com';
const CONF_MAIL_PORT = 587;
const CONF_MAIL_USER = 'fabricioalvespa@gmail.com';
const CONF_MAIL_PASS = 'epunuqvanzskqobi';
const CONF_MAIL_SENDER = ['name' => 'Fabrício', 'address' => 'fabricioalvespa@gmail.com'];

const CONF_MAIL_OPTION_LANG = 'br';
const CONF_MAIL_OPTION_HTML = true;
const CONF_MAIL_OPTION_SMTP_AUTH = true;
const CONF_MAIL_OPTION_SECURE = 'TLS';
const CONF_MAIL_OPTION_CHARSET = 'UTF-8';
