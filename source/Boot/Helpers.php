<?php

/**
 * ################
 * ###   URLs   ###
 * ################
 */ 
{
    function url(?string $path = null): string
    {
        if(false) {
            if ($path) {
                return CONF_URL_SENAC . '/views' . '/' . ($path[0] == '/' ? mb_substr($path, 1) : $path);
            }
            return CONF_URL_SENAC . '/views';
        }
        if (gettype(strpos($_SERVER['HTTP_HOST'], 'localhost')) == 'integer') {
            if ($path) {
                return CONF_URL_TEST . '/' . ($path[0] == '/' ? mb_substr($path, 1) : $path);
            }
            return CONF_URL_TEST;
        }
        if ($path) {
            return CONF_URL_BASE . ($path[0] == '/' ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_BASE;
    }
}

/**
 * ##################
 * ###   ASSETS   ###
 * ##################
 */ {
    function theme(string $path = null): string
    {
        if(false) {
            if ($path) {
                return CONF_URL_SENAC . '/views' . '/' . ($path[0] == '/' ? mb_substr($path, 1) : $path);
            }
            return CONF_URL_SENAC . '/views';
        }
        if (gettype(strpos($_SERVER['HTTP_HOST'], 'localhost')) == 'integer') {
            if ($path) {
                return CONF_URL_TEST . '/views' . '/' . ($path[0] == '/' ? mb_substr($path, 1) : $path);
            }
            return CONF_URL_TEST . '/views';
        }
        if ($path) {
            return CONF_URL_BASE . '/views' . '/' . ($path[0] == '/' ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_BASE . '/views';
    }
}
