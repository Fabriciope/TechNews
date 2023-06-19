<?php

use App\Core\Session;

/**
 * ####################
 * ###   VALIDATE   ###
 * ####################
 */ {
    function is_url(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED);
    }

    function is_urlEmbedYouTube(?string $url): bool
    {
        if(is_null($url)) return true;

        if (!is_url($url)) return false;

        $urlBase = substr($url, 0, 30);
        if ($urlBase == "https://www.youtube.com/embed/") return true;

        return false;
    }

    function is_urlYouTube(?string $url): bool
    {
        if(is_null($url)) return true;

        
        if (!is_url($url)) return false;

        $urlBase = substr($url, 0, 17);
        if ($urlBase == "https://youtu.be/") return true;

        return false;
    }

    function is_email(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function is_password(string $password): bool
    {
        $passLen = mb_strlen($password);

        if (password_get_info($password)['algo'] || ($passLen >= CONF_PASSWD_MIN_LEN && $passLen <= CONF_PASSWD_MAX_LEN)) {
            return true;
        }
        return false;
    }

    function generatePassword(string $password): string
    {
        if (empty(password_get_info($password)['algo'])) {
            return password_hash($password, CONF_PASSWD_ALGO, CONF_PASSWD_OPTIONS);
        }
        return $password;
    }

    function passwordVerify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    function password_rehash(string $hash): bool
    {
        return password_needs_rehash($hash, CONF_PASSWD_ALGO, CONF_PASSWD_OPTIONS);
    }

    function isLogged(): bool
    {
        if(\App\Models\AuthUser::user()) {
            return true;
        }
        return false;
    }
}

/**
 * ################
 * ###   URLs   ###
 * ################
 */ {
    function url(?string $path = null): string
    {
        if (false) {
            if ($path) {
                return CONF_URL_SENAC . '/views' . '/' . ($path[0] == '/' ? mb_substr($path, 1) : $path);
            }
            return CONF_URL_SENAC . '/views';
        }
        if (str_contains($_SERVER['HTTP_HOST'], 'localhost')) {
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

    function url_back(): string
    {
        if (isset($_SERVER['HTTP_REFERER']) && str_contains($_SERVER['HTTP_REFERER'], CONF_SITE_DOMAIN_TEST)) {
            return $_SERVER['HTTP_REFERER'] ;
        }
        return url();
    }

    function back(): void
    {
        if ($_SERVER['HTTP_REFERER'] && str_contains($_SERVER['HTTP_REFERER'], CONF_SITE_DOMAIN_TEST)) {
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }
        redirect(url());
    }

    function redirect(string $url): void
    {
        header("HTTP/1.1 302 Redirect");

        if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $url) {
            if(filter_var($url, FILTER_VALIDATE_URL)) {
                header("Location: {$url}");
                return;
            }
            $location = url($url);
            header("Location: {$location}");
        }
    }
}

/**
 * ################
 * ###   DATE   ###
 * ################
 */ {

    function date_fmt(string $date = 'now', string $format = 'd/m/Y H\hi'): string
    {
        return (new DateTime($date))->format($format);
    }
}

/**
 * ##################
 * ###   ASSETS   ###
 * ##################
 */ {
    function theme(string $path = null): string
    {
        if (false) {
            if ($path) {
                return CONF_URL_SENAC . '/views' . '/' . ($path[0] == '/' ? mb_substr($path, 1) : $path);
            }
            return CONF_URL_SENAC . '/views';
        }
        if (str_contains($_SERVER['HTTP_HOST'], 'localhost')) {
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

    function image(?string $image): ?string
    {
        if (empty($image)) return null;

        return url() . $image;
    }
}

/**
 * ##################
 * ###   STRING   ###
 * ##################
 */ {
    function str_slug(string $string): string
    {
        $string = mb_strtolower($string);

        $formats = [
            "/(ç|Ç)/",
            "/(á|à|ã|â|ä)/",
            "/(Á|À|Ã|Â|Ä)/",
            "/(é|è|ê|ë)/",
            "/(É|È|Ê|Ë)/",
            "/(í|ì|î|ï)/",
            "/(Í|Ì|Î|Ï)/",
            "/(ó|ò|õ|ô|ö)/",
            "/(Ó|Ò|Õ|Ô|Ö)/",
            "/(ú|ù|û|ü)/",
            "/(Ú|Ù|Û|Ü)/",
            "/(ñ)/", "/(Ñ)/"
        ];
        $replace = explode("-", "c-a-A-e-E-i-I-o-O-u-U-n-N- ");

        $slug = str_replace(
            ['--', '---', '----', '-----'],
            '-',
            str_replace(
                ' ',
                '-',
                trim(strtr(preg_replace($formats, $replace, $string), '"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª', '                                 '))
            )
        );
        return $slug;
    }

    function str_limit_words(string $string, int $limit, string $pointer = "..."): string
    {
        $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
        $arrWords = explode(' ', $string);
        $numWords = count($arrWords);

        if ($numWords <= $limit) return $string;

        $words = implode(' ', array_slice($arrWords, 0, $limit));
        return "{$words} {$pointer}";
    }

    function str_limit_chars(string $string, int $limit, string $pointer = '...'): string
    {
        $string = trim(filter_var(text($string)));

        if(mb_strlen($string) <= $limit) return $string;

        $chars = mb_substr($string, 0, mb_strrpos(mb_substr($string, 0, $limit), ' '));
        return "{$chars} {$pointer}";
    }

    function str_title(string $string): string
    {
        return ucwords(filter_var($string));
    }

    function convertToYouTubeEmbedUrl(string $url): string
    {
        $url = filter_var($url);
        $videoCode = substr($url, 17);

        return "https://www.youtube.com/embed/{$videoCode}";
    }
    
    function convertToYouTubeUrl(?string $embedUrl): string
    {
        if(is_null($embedUrl)) return '';

        $videoCode = substr($embedUrl, 30);

        return "https://youtu.be/{$videoCode}";
    }

    function text(?string $string): string
    {
        if(is_null($string) || empty($string)) return '';

        return htmlentities($string);
    }

}

/**
 * ###################
 * ###   REQUEST   ###
 * ###################
 */ {
    function csrf_input(): string
    {
        $session = session();
        $session->csrf();

        return "<input type='hidden' name='csrf' value='" . ($session->csrf_token ?? "") . "'/>";
    }

    function csrf_verify(array $request): bool
    {
        $session = session();

        $csrfToken = $session->csrf_token ?? '';
        $csrfRequest = $request['csrf'] ?? '';

        if (empty($csrfToken) || empty($csrfRequest) || $csrfToken != $csrfRequest) return false;
        return true;
    }

    function request_limit(
        string $requestName,
        int $requestLimit = 5,
        int $minutes = 3,
        bool $reset = false
    ): bool {
        $session = session();

        if ($reset && $session->has($requestName)) {
            $session->unset($requestName);
            return false;
        }

        $requestTime = $session->$requestName->time ?? null;
        $numberRequests = $session->$requestName->numberRequests ?? null;
        if ($session->has($requestName) && $requestTime >= time() && $numberRequests < $requestLimit) {
            $session->set($requestName, [
                'time' => time() + $minutes,
                'numberRequests' => ++$numberRequests
            ]);
            return false;
        }

        if ($session->has($requestName) && $requestTime >= time() && $numberRequests >= $requestLimit) {
            return true;
        }

        $session->set($requestName, [
            'time' => time() + $minutes,
            'numberRequests' => 1
        ]);
        return false;
    }

    function request_repeat(string $field, string $value): bool
    {
        $session = session();

        if ($session->has($field) && $session->$field == $value) return true;

        $session->set($field, $value);
        return false;
    }
}

function flash(): ?\App\Support\Message
{
    return session()->getFlashMessage();
}

function session(): Session
{
    return new App\Core\Session;
}
