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
