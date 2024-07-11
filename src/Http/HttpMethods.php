<?php

namespace Src\Http;

enum HttpMethods
{
    case GET;
    case POST;
    case PUT;
    case PATCH;
    case DELETE;
}
