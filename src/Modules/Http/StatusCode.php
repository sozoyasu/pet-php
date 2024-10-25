<?php

namespace Modules\Http;

enum StatusCode: int
{
    case Code100 = 100;
    case Code101 = 101;
    case Code102 = 102;
    case Code103 = 103;
    case Code104 = 104;

    case Code200 = 200;
    case Code201 = 201;
    case Code202 = 202;
    case Code203 = 203;
    case Code204 = 204;
    case Code205 = 205;
    case Code206 = 206;
    case Code207 = 207;

    case Code300 = 300;
    case Code301 = 301;
    case Code302 = 302;
    case Code303 = 303;
    case Code304 = 304;
    case Code305 = 305;
    case Code306 = 306;
    case Code307 = 307;

    case Code400 = 400;
    case Code401 = 401;
    case Code402 = 402;
    case Code403 = 403;
    case Code404 = 404;
    case Code405 = 405;
    case Code406 = 406;
    case Code407 = 407;
    case Code408 = 408;
    case Code409 = 409;
    case Code410 = 410;
    case Code411 = 411;
    case Code412 = 412;
    case Code413 = 413;
    case Code414 = 414;
    case Code415 = 415;
    case Code416 = 416;
    case Code417 = 417;
    case Code418 = 418;
    case Code419 = 419;
    case Code420 = 420;
    case Code421 = 421;
    case Code422 = 422;
    case Code423 = 423;
    case Code424 = 424;
    case Code425 = 425;
    case Code426 = 426;
    case Code428 = 428;
    case Code429 = 429;
    case Code431 = 431;
    case Code444 = 444;

    case Code500 = 500;
    case Code501 = 501;
    case Code502 = 502;
    case Code503 = 503;
    case Code504 = 504;
    case Code505 = 505;
    case Code506 = 506;
    case Code507 = 507;
    case Code508 = 508;
    case Code510 = 510;
    case Code511 = 511;

    public function getPhrase(): string
    {
        $phrases = [
            // INFORMATIONAL CODES
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            103 => 'Early Hints',
            // SUCCESS CODES
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            208 => 'Already Reported',
            226 => 'IM Used',
            // REDIRECTION CODES
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => 'Switch Proxy', // Deprecated to 306 => '(Unused)'
            307 => 'Temporary Redirect',
            308 => 'Permanent Redirect',
            // CLIENT ERROR
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Content Too Large',
            414 => 'URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Range Not Satisfiable',
            417 => 'Expectation Failed',
            418 => 'I\'m a teapot',
            421 => 'Misdirected Request',
            422 => 'Unprocessable Content',
            423 => 'Locked',
            424 => 'Failed Dependency',
            425 => 'Too Early',
            426 => 'Upgrade Required',
            428 => 'Precondition Required',
            429 => 'Too Many Requests',
            431 => 'Request Header Fields Too Large',
            444 => 'Connection Closed Without Response',
            451 => 'Unavailable For Legal Reasons',
            // SERVER ERROR
            499 => 'Client Closed Request',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            508 => 'Loop Detected',
            510 => 'Not Extended (OBSOLETED)',
            511 => 'Network Authentication Required',
            599 => 'Network Connect Timeout Error',
        ];

        return $phrases[$this->value];
    }
}