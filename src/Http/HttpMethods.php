<?php

namespace Src\Http;

enum HttpMethods
{
    case GET;
    case POST;
    case PUT;
    case PATCH;
    case DELETE;

    public static function caseExists(string $case): bool
    {
        foreach (self::cases() as $httpMethod) {
            if ($httpMethod->name == $case) {
                return true;
            }
        }

        return false;
    }
}
