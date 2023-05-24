<?php
use Source\Core\Session;


/**
 * ####################
 * ###   VALIDATE   ###
 * ####################
 */
{
    function is_email(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function is_password(string $password): bool
    {
        $passLen = mb_strlen($password);

        if ($passLen >= CONF_PASSWD_MIN_LEN && $passLen <= CONF_PASSWD_MAX_LEN) {
            return true;
        }
        return false;
    }

    function generatePassword(string $password): ?string
    {
        if(empty(password_get_info($password)['algo'])) {
            return password_hash($password, CONF_PASSWD_ALGO, CONF_PASSWD_OPTIONS);
        }
        return null;
    }

    function passwordVeriry(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}



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

    function redirect(string $url): void
    {
        header("HTTP/1.1 302 Redirect");

        if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $url) {
            $location = url($url);
            header("Location: {$location}");
        }
    }
}

/**
 * ##################
 * ###   ASSETS   ###
 * ##################
 */ 
{
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


/**
 * ###################
 * ###   REQUEST   ###
 * ###################
 */ 
{
    function csrf_input(): string
    {
        $session = session();
        $session->csrf();

        return "<input type='text' name='csrf' value='". ($session->csrf_token ?? "") . "'/>";
    }

    function csrf_verify(array $request): bool
    {
        $session = session();

        $csrfToken = $session->csrf_token;
        $csrfRequest = $request['csrf'];

        if(empty($csrfToken) || empty($csrfRequest) || $csrfToken != $csrfRequest) return false;
        return true;
    }

    function flash(): ?string
    {
        return session()->getFlashMessage();
    }
}




{
    function session(): Session
    {
        return new Source\Core\Session;
    }
}
