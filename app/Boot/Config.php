<?php


/**
 *   CONNECTION DB
 */ {
    define("CONF_DB_HOST", "localhost");
    define("CONF_DB_NAME", "TechNews");
    define("CONF_DB_USER", "root");
    define("CONF_DB_PASSWORD", "");
}



/**
 *   PROJECT URLs
 */ {
    define("CONF_URL_BASE", "http://localhost/TechNews.com");
    define("CONF_URL_TEST", "http://localhost/TechNews");
    define("CONF_URL_SENAC", "http://localhost/repos-TechNews/");

    define("CONF_PATH_VIEWS", CONF_URL_BASE . "/views");
}

/**
 * PASSWORD
 */ {

    define("CONF_PASSWD_MIN_LEN", 6);
    define("CONF_PASSWD_MAX_LEN", 40);
    define("CONF_PASSWD_ALGO", PASSWORD_DEFAULT);
    define("CONF_PASSWD_OPTIONS", ["cost" => 10]);
}

/**
 * UPLOAD
 */
define("CONF_UPLOAD_DIR", "/storage/uploads");
define("CONF_UPLOAD_IMAGE_DIR", "images");
define("CONF_UPLOAD_PHOTO_DIR", CONF_UPLOAD_IMAGE_DIR . "/photos");
define("CONF_UPLOAD_BANNER_DIR", CONF_UPLOAD_IMAGE_DIR . "/banners");

/**
 * IMAGES
 */
define("CONF_IMAGE_CACHE", CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR . "/cache");
define("CONF_IMAGE_SIZE", 'sei la');
define("CONF_IMAGE_QUALITY", ["jpg" => 72, "png" => 5]);

define("CONF_IMAGE_PHOTO_SIZE", 650);
define("CONF_IMAGE_BANNER_SIZE", 1150);


/**
 *   MAIL
 */ {
    // define("CONF_MAIL_HOST", "smtp.gmail.com");
    // define("CONF_MAIL_PORT", 587);
    // define("CONF_MAIL_USER", "fabriciolves.dev@gmail.com");
    // define("CONF_MAIL_PASS", "Escooby098.");
    // define("CONF_MAIL_SENDER", [
    //     "name" => "Fabrício",
    //     "address" => "fabricioalves.dev@gmail.com"
    // ]);

    define("CONF_MAIL_HOST", "smtp.gmail.com");
    define("CONF_MAIL_PORT", 587);
    define("CONF_MAIL_USER", "fabricioalvespa@gmail.com");
    define("CONF_MAIL_PASS", "epunuqvanzskqobi");
    define("CONF_MAIL_SENDER", ["name" => "Fabrício", "address" => "fabricioalvespa@gmail.com"]);

    define("CONF_MAIL_OPTION_LANG", "br");
    define("CONF_MAIL_OPTION_HTML", true);
    define("CONF_MAIL_OPTION_SMTP_AUTH", true);
    define("CONF_MAIL_OPTION_SECURE", "TLS");
    define("CONF_MAIL_OPTION_CHARSET", "UTF-8");
}
